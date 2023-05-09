function showDetails(transactionCode) {
    $.ajax({
        url: base_url + 'dashboard/transaksi/details/' + transactionCode,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // populate the table with the transaction items
                var items = response.data;
                var total = 0;
                var table = $('#form').find('table tbody');
                table.empty();
                for (var i = 0; i < items.length; i++) {
                    var item = items[i];
                    var subTotal = item.selling_price * item.quantity;
                    total += subTotal;
                    table.append('<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td>' + item.name + '</td>' +
                        '<td>IDR ' + item.selling_price + '</td>' +
                        '<td>' + item.quantity + '</td>' +
                        '<td>' + item.unit + '</td>' +
                        '<td>IDR ' + subTotal + '</td>' +
                        '</tr>');
                }

                // set the total price
                $('#waktu').text(response.data.created_at);
                $('#kode_transaksi').text(response.data.transaction_code);
                $('#myModal').modal('show');
                $('#total').text(total);
            }
        },
        error: function(xhr, status, error) {
            console.log(error);
        }
    });
}

function save() {
    const id = $('#id').val();
    const url = id ? `${base_url}dashboard/items/update/${id}` : `${base_url}dashboard/items`;
    
    $.ajax({
      url,
      type: 'POST',
      data: $('#form').serialize(),
      dataType: 'JSON',
      success: ({ success, message }) => {
        alert(message);
        if (success) {
          window.location.href = `${base_url}dashboard/items`;
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
            url: `${base_url}dashboard/items/delete/${id}`,
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
