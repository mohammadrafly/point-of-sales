function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); 
    $.ajax({
        url : `${base_url}dashboard/items/update/${id}`,
        type: 'GET',
        dataType: 'JSON',
        success: function(respond)
        {
            $('[name="id"]').val(respond.data.id);
            $('[name="name"]').val(respond.data.name);
            $('[name="description"]').val(respond.data.description);
            $('[name="selling_price"]').val(respond.data.selling_price);
            $('[name="purchase_price"]').val(respond.data.purchase_price);
            $('[name="stock"]').val(respond.data.stock);
            $('[name="unit"]').val(respond.data.unit);
            $('#myModal').modal('show');
            $('.modal-title').text('Edit Barang'); 
        },
        error: function (textStatus)
        {
            alert(textStatus);
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
