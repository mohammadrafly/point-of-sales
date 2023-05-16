function formatRupiah(value) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
  }
  
  function showDetails(id) {
      $.ajax({
        url: base_url + 'dashboard/hutang/supplier/details/' + id,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
          if (response.success) {
    
            $('#cicil_hutang_label').text('Total cicil: ' + formatRupiah(response.data.cicil));
            // set the total price
            console.log(response);
            $('#waktu').text(response.data.created_at);
            $('#supplier_name').text(response.data.supplier);
            $('#debt').text(formatRupiah(response.data.hutang));
            if (response.data.status == 'cicil') {
              $('#status').html('<span class="badge badge-danger">' + 'Cicil' + '</span>');
            } else if (response.data.status == 'lunas') {
              $('#status').html('<span class="badge badge-success">' + 'Sudah Bayar' + '</span>');
            }
    
            if (response.data.status == 'cicil') {
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
            
                // Append the label and input field to the modal body
                $('#formDetail').append(cicilHutangInput);
            
                // Add an event listener to the "Cicil" button
                $('#button-cicil').on('click', function() {
                  var cicilHutangValue = $('#cicil_hutang').val();
                  if (cicilHutangValue.trim() !== '') {
                    // Call the cicilHutang function passing the transaction code and cicil hutang value
                    cicilHutang(response.data.id, cicilHutangValue);
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
            
    
            console.log(response.data.status)
            $('#detailModal').modal('show');
          }
        },
        error: function(error) {
          console.log(error);
        }
      });
    }
    
  
  function cicilHutang(kode,cicil) {
      const url = `${base_url}dashboard/hutang/supplier/bayar/${kode}`;
  
      $.ajax({
          url,
          type: 'POST',
          data: $('#detail-form').serialize() + '&cicil=' + cicil,
          dataType: 'JSON',
          success: ({ message }) => {
            alert(message);
            location.reload();
          },
          error: () => {
            alert('An error occurred while processing your request.');
          },
        });
  } 
  
  function save() {
    $.ajax({
      url: `${base_url}dashboard/hutang/supplier`,
      type: 'POST',
      data: $('#form').serialize(),
      dataType: 'JSON',
      success: ({ message }) => {
        alert(message);
        location.reload()
      },
      error: () => {
        alert('An error occurred while processing your request.');
      },
    });
  }

  function deleteData(id) {
      if (confirm('Anda yakin ingin melakukan operasi ini?')) {
          $.ajax({
              url: `${base_url}dashboard/hutang/supplier/delete/${id}`,
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
  