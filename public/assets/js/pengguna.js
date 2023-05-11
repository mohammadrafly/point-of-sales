function edit(id) {
    save_method = 'update';
    $('#form')[0].reset(); 
    $.ajax({
        url : `${base_url}dashboard/users/update/${id}`,
        type: 'GET',
        dataType: 'JSON',
        success: function(respond)
        {
            $('[name="id"]').val(respond.data.id);
            $('[name="name"]').val(respond.data.name);
            $('[name="role"]').val(respond.data.role);
            $('[name="address"]').val(respond.data.address);
            $('[name="phone_number"]').val(respond.data.phone_number);
            $('#myModal').modal('show');
            $('.modal-title').text('Edit Pengguna'); 

            $('#password-input').hide();
            $('#username-input').hide();
            $('#email-input').hide();
        },
        error: function (textStatus)
        {
            alert(textStatus);
        }
    });
}

function save() {
    const id = $('#id').val();
    const url = id ? `${base_url}dashboard/users/update/${id}` : `${base_url}dashboard/users`;
    
    $.ajax({
      url,
      type: 'POST',
      data: $('#form').serialize(),
      dataType: 'JSON',
      success: ({ success, message }) => {
        alert(message);
        if (success) {
          window.location.href = `${base_url}dashboard/users`;
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
            url: `${base_url}dashboard/users/delete/${id}`,
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
