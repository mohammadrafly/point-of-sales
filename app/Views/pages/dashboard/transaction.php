<?= $this->extend('layout/templateDashboard') ?>
<?= $this->section('content') ?>  
<div class="row">
  <div class="col-lg-12">
    <div class="card">
      <div class="card-header">
        <h4>Transaksi</h4>
      </div>
      <div class="card-body">
        <div class="form-row mb-5">
          <div class="col-md-3">
            <select class="form-control select2" name="name" onchange="updateFields(this)">
              <option value="">Select Item</option>
              <?php foreach($barang as $data): ?>
                <option value="<?= $data['id'] ?>" data-price="<?= $data['selling_price'] ?>" data-unit="<?= $data['unit'] ?>"><?= $data['name'] ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control" name="price" placeholder="Price" readonly>
          </div>
          <div class="col-md-2">
            <input type="number" class="form-control" name="quantity" placeholder="Quantity" oninput="updateSubtotal(this)">
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control" name="unit" placeholder="Unit" readonly>
          </div>
          <div class="col-md-2">
            <input type="text" class="form-control" name="subtotal" placeholder="Subtotal" readonly>
          </div>
          <div class="col-md-1">
            <button type="button" class="btn btn-primary" onclick="addToTable()">Add</button>
          </div>
        </div>
          <form id="my-form">
            <div class="table-responsive">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th>Nama Barang</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Satuan</th>
                    <th>Sub Total</th>
                    <th>Opsi</th>
                  </tr>
                </thead>
                <tbody id="tableBody">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5" class="text-right"><strong>Total:</strong></td>
                    <td><strong><div id="total" name="total" readonly></div></strong></td>
                  </tr>
                </tfoot>
              </table>
            </div>
            <input type="hidden" name="table_data" id="table_data">
            <hr>
            <div class="form-group">
              <label for="payment_type">Metode Pembayaran</label>
              <select class="form-control" id="payment_type" name="payment_type">
                  <option value="hutang">Hutang</option>
                  <option value="tunai">Tunai</option>
              </select>
            </div>
            <div class="form-group">
              <label for="payment_type">Customer</label>
              <select class="select2 form-control" id="user_id" name="user_id">
                <?php foreach($user as $data): ?>
                <option value="<?= $data['id'] ?>"><?= $data['name'] ?></option>
                <?php endforeach ?>
              </select>
            </div>
            <button type="button" class="btn btn-primary" onclick="postData()">Simpan</button>
          </form>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
  function convertKgToG(value, price) {
    // Convert kg to g
    var grams = value * 1000;

    // Adjust the price
    var adjustedPrice = price / grams;

    return {
      grams: grams,
      adjustedPrice: adjustedPrice.toFixed(2)
    };
  }

  // Example usage
  var weightInKg = 0.1;
  var pricePerKg = 10000;

  var conversionResult = convertKgToG(weightInKg, pricePerKg);

  console.log("Weight in grams: " + conversionResult.grams);
  console.log("Adjusted price per gram: " + conversionResult.adjustedPrice);

  var totalPrice = pricePerKg * weightInKg;
  console.log("Total price: " + totalPrice + " rupiah");


 function addToTable() {
    // Get form field values
    var nameSelect = document.querySelector('select[name="name"]');
    var name = nameSelect.options[nameSelect.selectedIndex].text; // Get the selected option text
    var id = nameSelect.value;
    var price = document.querySelector('input[name="price"]').value;
    var quantity = document.querySelector('input[name="quantity"]').value;
    var unit = document.querySelector('input[name="unit"]').value;
    var subtotal = document.querySelector('input[name="subtotal"]').value;

    // Create a new table row
    var newRow = document.createElement('tr');

    var idCell = document.createElement('td');
    idCell.style.display = 'none'; // Set the display style to 'none' to hide the cell
    idCell.textContent = id;
    newRow.appendChild(idCell);

    // Create table cells and populate them with form field values
    var nameCell = document.createElement('td');
    nameCell.textContent = name;
    newRow.appendChild(nameCell);

    var priceCell = document.createElement('td');
    priceCell.textContent = price;
    newRow.appendChild(priceCell);

    var quantityCell = document.createElement('td');
    quantityCell.textContent = quantity;
    newRow.appendChild(quantityCell);

    var unitCell = document.createElement('td');
    unitCell.textContent = unit;
    newRow.appendChild(unitCell);

    var subtotalCell = document.createElement('td');
    subtotalCell.textContent = subtotal;
    newRow.appendChild(subtotalCell);

    // Create a delete button
    var deleteButton = document.createElement('button');
    deleteButton.textContent = 'Delete';
    deleteButton.classList.add('btn', 'btn-danger');
    deleteButton.addEventListener('click', function() {
      newRow.remove(); // Remove the row when delete button is clicked
      updateTotal(); // Update the total after deletion
    });

    var deleteCell = document.createElement('td');
    deleteCell.appendChild(deleteButton);
    newRow.appendChild(deleteCell);

    // Append the new row to the table body
    var tableBody = document.getElementById('tableBody');
    tableBody.appendChild(newRow);

    // Clear the form field values
    document.querySelector('select[name="name"]').selectedIndex = 0;
    document.querySelector('input[name="price"]').value = '';
    document.querySelector('input[name="quantity"]').value = '';
    document.querySelector('input[name="unit"]').value = '';
    document.querySelector('input[name="subtotal"]').value = '';

    updateTotal(); // Update the total after adding the new row
  }

  function updateTotal() {
    var tableRows = document.querySelectorAll('#tableBody tr');
    var total = 0;

    tableRows.forEach(function(row) {
      var subtotalCell = row.querySelector('td:nth-child(6)');
      var subtotal = parseFloat(subtotalCell.textContent);

      if (!isNaN(subtotal)) {
        total += subtotal;
      }
    });

    var totalCell = document.getElementById('total');

    // Display the formatted currency value
    totalCell.textContent = total.toLocaleString('id-ID', { style: 'currency', currency: 'IDR' });

    // Store the raw number as a data attribute for the POST request
    totalCell.dataset.value = total;
  }

  function updateFields(selectElement) {
    var selectedOption = selectElement.options[selectElement.selectedIndex];
    var priceInput = selectElement.parentNode.parentNode.querySelector('input[name="price"]');
    var unitInput = selectElement.parentNode.parentNode.querySelector('input[name="unit"]');
    var subtotalInput = selectElement.parentNode.parentNode.querySelector('input[name="subtotal"]');
    
    priceInput.value = selectedOption.getAttribute('data-price');
    unitInput.value = selectedOption.getAttribute('data-unit');
    subtotalInput.value = '';
  }

  function updateSubtotal(quantityInput) {
    var formRow = quantityInput.parentNode.parentNode;
    var price = parseFloat(formRow.querySelector('input[name="price"]').value);
    var quantity = parseFloat(quantityInput.value);
    var subtotal = formRow.querySelector('input[name="subtotal"]');
    
    if (!isNaN(price) && !isNaN(quantity)) {
      subtotal.value = (price * quantity);
    } else {
      subtotal.value = '';
    }
  }

  function postData() {
    // Get the form data
    var form = document.getElementById('my-form');
    var formData = new FormData(form);

    // Get the table rows
    var tableRows = document.querySelectorAll('#tableBody tr');

    // Iterate over each row and extract the data
    var idItems = [];
    var quantities = [];
    var totalPrices = [];
    tableRows.forEach(function(row) {
      var cells = row.querySelectorAll('td');
      idItems.push(cells[0].textContent); // Assuming the first cell contains the ID
      quantities.push(cells[3].textContent); // Assuming the third cell contains the quantity
      totalPrices.push(cells[5].textContent); // Assuming the fifth cell contains the subtotal
    });

    // Get the payment_type and user_id values
    var paymentType = document.getElementById('payment_type').value;
    var userId = document.getElementById('user_id').value;

    // Add the payment_type, user_id, id_items, quantities, total_prices to the form data
    formData.append('payment_type', paymentType);
    formData.append('user_id', userId);
    
    idItems.forEach(function(idItem, index) {
      formData.append('id_items[]', idItem);
      formData.append('quantity[]', quantities[index]);
      formData.append('total_price[]', totalPrices[index]);
    });

    // Send the POST request
    fetch(`${base_url}dashboard/transaction`, {
      method: 'POST',
      body: formData
    })
    .then(response => response.json())
    .then(data => {
      if (data.success) {
        alert(data.message);
        location.reload();
      } else {
        console.error(data.message);
      }
    })
    .catch(error => {
      console.error('Error:', error);
    });
  }

  $(document).ready(function() {
    $('.select2').select2({
      placeholder: 'Select an option',
      allowClear: true
    });
  });

</script>
<?= $this->endSection() ?>