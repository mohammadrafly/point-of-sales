function formatRupiah(value) {
  return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
}

function showDetails(transactionCode) {
    $.ajax({
      url: base_url + 'dashboard/transaksi/details/' + transactionCode,
      type: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.success) {
          // populate the table with the transaction data
          var transaksi = response.data;
          var total = 0;
          var table = $('#form').find('table tbody');
          table.empty();
          for (var i = 0; i < transaksi.length; i++) {
            var item = transaksi[i];
            var sellingPrice = Number(item.selling_price);
            var subTotal = item.selling_price * item.quantity;
            total += subTotal;
            table.append(
              '<tr>' +
              '<td>' + (i + 1) + '</td>' +
              '<td>' + item.name + '</td>' +
              '<td>' + sellingPrice.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) + '</td>' +
              '<td>' + item.quantity + ' ' + item.unit + '</td>' +
              '<td>' + subTotal.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }) + '</td>' +
              '</tr>'
            );
          }
  
          console.log()
          if (response.data[0].payment_type === 'hutang') {
            $('#cicil_hutang_label').text('Total cicil: ' + formatRupiah(response.data[0].cicil));
          } else {
            $('#cicil_hutang_label').text('');
          }
          // set the total price
          $('#waktu').text(response.data[0].created_at);
          $('#kode_transaksi').text(response.data[0].transaction_code);
          $('#customer').text(response.data[0].nama_user);
          if (response.data[0].status == 'cicil') {
            $('#status').html('<span class="badge badge-danger">' + 'Cicil' + '</span>');
          } else if (response.data[0].status == 'done') {
            $('#status').html('<span class="badge badge-success">' + 'Sudah Bayar' + '</span>');
          }
  
          if (response.data[0].payment_type == 'hutang') {
            if (response.data[0].status == 'cicil') {
              $('#button-cicil').attr('hidden', false);
          
              // Create a new input field for "Cicil Hutang"
              var cicilHutangInput = $('<input>').attr({
                'type': 'number',
                'id': 'cicil_hutang',
                'name': 'cicil_hutang',
                'class': 'form-control',
                'placeholder': 'Cicil Hutang',
                'required': true
              });
          
              // Create a new label for the input field
              var cicilHutangLabel = $('<label>').attr('for', 'cicil_hutang').text('Cicil Hutang:');
          
              // Append the label and input field to the modal body
              $('#form').append(cicilHutangLabel, cicilHutangInput);
          
              // Add an event listener to the "Cicil" button
              $('#button-cicil').on('click', function() {
                var cicilHutangValue = $('#cicil_hutang').val();
                if (cicilHutangValue.trim() !== '') {
                  // Call the cicilHutang function passing the transaction code and cicil hutang value
                  cicilHutang(response.data[0].transaction_code, cicilHutangValue);
                } else {
                  alert('Please enter a valid Cicil Hutang value.');
                }
              });              
            } else {
              $('#button-cicil').attr('hidden', true);
              // Remove the input field for "Cicil Hutang"
              $('#cicil_hutang').remove();
              $('label[for="cicil_hutang"]').remove();
            }
          } else {
            $('#button-cicil').attr('hidden', true);
            // Remove the input field for "Cicil Hutang"
            $('#cicil_hutang').remove();
            $('label[for="cicil_hutang"]').remove();
          }
          
  
          console.log(response.data[0].status)
          $('#myModal').modal('show');
          $('#total').text(total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
        }
      },
      error: function(error) {
        console.log(error);
      }
    });
  }
  

function cicilHutang(kode,cicil) {
    const url = `${base_url}dashboard/transaksi/bayar/${kode}`;

    $.ajax({
        url,
        type: 'POST',
        data: $('#detail-form').serialize() + '&cicil=' + cicil,
        dataType: 'JSON',
        success: ({ success, message }) => {
          console.log($('#detail-form').serialize());
          alert(message);
          if (success) {
            window.location.href = `${base_url}dashboard/transaksi/type/hutang`;
          }
        },
        error: () => {
          alert('An error occurred while processing your request.');
        },
      });
} 

function deleteData(id) {
    if (confirm('Anda yakin ingin melakukan operasi ini?')) {
        $.ajax({
            url: `${base_url}dashboard/transaksi/delete/${id}`,
            type: 'GET',
            dataType: 'JSON',
            success: function (response) {
                alert(response.message);
                location.reload();
            },
            error: function (textStatus) {
                alert(textStatus);
            }
        });
    } else {
        // User clicked Cancel, do nothing
    }     
}

$('#myModal').on('hidden.bs.modal', function () {
    location.reload();
});
