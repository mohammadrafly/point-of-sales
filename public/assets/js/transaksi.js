function showDetails(transactionCode) {
    $.ajax({
        url: base_url + 'dashboard/transaksi/details/' + transactionCode,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.success) {
                // populate the table with the transaction transaksi
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

                // set the total price
                $('#waktu').text(response.data[0].created_at);
                $('#kode_transaksi').text(response.data[0].transaction_code);
                $('#customer').text(response.data[0].nama_user);
                if (response.data[0].status == 'no_payment') {
                    $('#status').html('<span class="badge badge-danger">' + 'Belum Bayar' + '</span>');
                } else if (response.data[0].status == 'done') {
                    $('#status').html('<span class="badge badge-success">' + 'Sudah Bayar' + '</span>');
                } else {
                    $('#status').html('<span class="badge badge-warning">' + 'Bayar Setengah' + '</span>');
                }
                if (response.data[0].status == 'no_payment') {
                    $('#button-bayar').attr('onclick', 'bayarHutang("' + response.data[0].transaction_code + '")').attr('hidden', false);
                }
                $('#myModal').modal('show');
                $('#total').text(total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' }));
            }
        },
        error: function(error) {
            console.log(error);
        }
    });
}

function bayarHutang(kode) {
    const url = `${base_url}dashboard/transaksi/bayar/${kode}`;

    $.ajax({
        url,
        type: 'POST',
        data: $('#detail-form').serialize(),
        dataType: 'JSON',
        success: ({ success, message }) => {
          alert(message);
          if (success) {
            window.location.href = `${base_url}dashboard/transaksi`;
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
