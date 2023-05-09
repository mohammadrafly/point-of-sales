<?= $this->extend('layout/templateDashboard') ?>
<?= $this->section('content') ?>  
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Transaksi</h4>
      </div>
      <div class="card-body">
        <form id="my-form">
            <div class="form-row">
              <div class="form-group col-md-2">
                <label for="name">Nama Barang</label>
                <select class="form-control" id="name" name="name[]" data-price="" data-unit="">
                    <?php foreach($barang as $data): ?>
                    <option value="<?= $data['id'] ?>" data-price="<?= $data['selling_price'] ?>" data-unit="<?= $data['unit'] ?>"><?= $data['name'] ?></option>
                    <?php endforeach ?>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label for="harga_barang">Harga Barang</label>
                <input type="text" class="form-control" id="harga_barang" name="harga_barang" readonly>
              </div>
              <div class="form-group col-md-2">
                <label for="quantity">Jumlah</label>
                <input type="number" class="form-control" id="quantity" name="quantity[]">
              </div>
              <div class="form-group col-md-2">
                <label for="satuan">Satuan</label>
                <input type="text" class="form-control" id="satuan" name="satuan" readonly>
              </div>
              <div class="form-group col-md-2">
                <label for="total_price">Sub Total</label>
                <input type="text" class="form-control" id="total_price" name="total_price[]" readonly>
              </div>
              <div class="form-group col-md-2">
                <label for="total_price">#</label>
                <button class="btn btn-danger delete-row form-control">Delete</button>
              </div>
            </div>
            <div id="form-rows"></div>
            
            <hr>
            <div class="form-group">
              <label for="total">Total</label>
              <input type="text" class="form-control" id="total" name="total" readonly>
            </div>
            <div class="form-group">
              <label for="payment_type">Metode Pembayaran</label>
              <select class="form-control" id="payment_type" name="payment_type">
                  <option value="hutang">Hutang</option>
                  <option value="tunai">Tunai</option>
              </select>
            </div>
            <button type="button" class="btn btn-success add-row-btn">Tambah Form</button>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
$(function() {
  // Add row button click event handler
  $('.add-row-btn').click(function() {
    // Create a new form row
    var $newRow = $('<div class="form-row">');
    // Add the form row HTML to the new form row
    $newRow.html(`
      <div class="form-group col-md-2">
        <label for="name">Nama Barang</label>
        <select class="form-control" id="name" name="name[]" data-price="" data-unit="">
            <?php foreach($barang as $data): ?>
            <option value="<?= $data['id'] ?>" data-price="<?= $data['selling_price'] ?>" data-unit="<?= $data['unit'] ?>"><?= $data['name'] ?></option>
            <?php endforeach ?>
        </select>
      </div>
      <div class="form-group col-md-2">
        <label for="harga_barang">Harga Barang</label>
        <input type="text" class="form-control" id="harga_barang" name="harga_barang" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="quantity">Jumlah</label>
        <input type="number" class="form-control" id="quantity" name="quantity[]">
      </div>
      <div class="form-group col-md-2">
        <label for="satuan">Satuan</label>
        <input type="text" class="form-control" id="satuan" name="satuan" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="total_price">Sub Total</label>
        <input type="text" class="form-control" id="total_price" name="total_price[]" readonly>
      </div>
      <div class="form-group col-md-2">
        <label for="total_price">#</label>
        <button class="btn btn-danger delete-row form-control">Delete</button>
      </div>
    `);
    // Append the new form row to the form rows container
    $('#form-rows').append($newRow);
  });

  $(document).on('change', 'select[name="name[]"]', function() {
    var selectedOption = $(this).find('option:selected');
    var price = selectedOption.data('price');
    $(this).attr('data-price', price);
    var quantity = $(this).closest('.form-row').find('input[name="quantity[]"]').val();
    var subTotal = price * quantity;
    $(this).closest('.form-row').find('input[name="harga_barang"]').val(price);
    $(this).closest('.form-row').find('input[name="total_price[]"]').val(subTotal);
  });

  $(document).on('change', '#name', function() {
    var selectedOption = $(this).find(':selected');
    var unit = selectedOption.data('unit');
    $(this).closest('.form-row').find('#satuan').val(unit);
  });

  // Update total_price field when quantity is changed
  $(document).on('change', 'input[name="quantity[]"]', function() {
    var quantity = $(this).val();
    var price = $(this).closest('.form-row').find('select[name="name[]"]').data('price');
    var subTotal = price * quantity;
    $(this).closest('.form-row').find('input[name="total_price[]"]').val(subTotal);

    // Update the total field
    var total = 0;
    $('input[name="total_price[]"]').each(function() {
      var subtotal = parseFloat($(this).val());
      if (!isNaN(subtotal)) {
        total += subtotal;
      }
    });
    $('#total').val(total);
  });

  $(document).on('click', '.delete-row', function() {
    $(this).closest('.form-row').remove();
  });

  // Form submit event handler
  $('#my-form').submit(function(event) {
    // Prevent the form from submitting normally
    event.preventDefault();
    // Send the form data to the server using AJAX
    $.ajax({
      url: `${base_url}dashboard/transaction`,
      method: 'POST',
      data: $(this).serialize(),
      success: function(response) {
        // Handle the response from the server
        alert('Success adding to cart')
        location.reload();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        // Handle errors
        alert('Failed adding to cart')
      }
    });
  });
});
</script>
<?= $this->endSection() ?>