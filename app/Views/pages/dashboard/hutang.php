<?= $this->extend('layout/templateDashboard') ?>
<?= $this->section('content') ?>  

                    <div class="card shadow mb-4">
                        <div class="card-body">
                            <div class="form-row mb-5">
                                <div class="col-md-3">
                                    <input type="text" class="form-control" name="name" placeholder="Nama Barang">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="price" placeholder="Harga">
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" name="quantity" placeholder="Jumlah Barang" oninput="updateSubtotal(this)">
                                </div>
                                <div class="col-md-2">
                                    <select class="form-control" id="unit" name="unit">
                                        <option>Pilih satuan</option>
                                        <option value="KG">KILOGRAM</option>
                                        <option value="PCS">PCS</option>
                                        <option value="RENCENG">RENCENG</option>
                                        <option value="PAK">PAK</option>
                                        <option value="ONS">ONS</option>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <input type="text" class="form-control" name="subtotal" placeholder="Subtotal" readonly>
                                </div>
                                <div class="col-md-1">
                                    <button type="button" class="btn btn-primary" onclick="addToTable()">Tambah</button>
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
                                <div class="form-group" id="supplier_field">
                                    <label for="payment_type">Supplier</label>
                                    <input type="text" class="form-control" name="supplier" id="supplier">
                                </div>
                                <button type="button" class="btn btn-primary" onclick="postData()">Simpan</button>
                            </form>
                        </div>
                    </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data Hutang</h6>
                            <div>
                                <button class="btn btn-success" data-toggle="modal" data-target="#dateRangeModal">Cetak Excel</button>
                            </div>
                        </div>
                        <div class="modal fade" id="dateRangeModal" tabindex="-1" role="dialog" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="dateRangeModalLabel">Select Date Range</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <form action="<?= base_url('dashboard/export/hutang')?>" method="post">
                                        <div class="modal-body">
                                            <!-- Date range selection inputs -->
                                            <div class="form-group">
                                                <label for="startDate">Tanggal Mulai</label>
                                                <input type="date" class="form-control" id="startDate" name="startDate">
                                            </div>
                                            <div class="form-group">
                                                <label for="endDate">Tanggal Akhir</label>
                                                <input type="date" class="form-control" id="endDate" name="endDate">
                                            </div>
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="">Semua</option>
                                                        <option value="lunas">Sudah Lunas</option>
                                                        <option value="cicil">Cicil</option>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Cetak</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="detailModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Detail</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="formDetail">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="transaction-info">
                                                    <div class="info-row">
                                                        <span class="info-label"><strong>Waktu Transaksi:</strong></span>
                                                        <span id="waktu" class="info-value"></span>
                                                    </div>
                                                    <div class="info-row">
                                                        <span class="info-label"><strong>Hutang:</strong></span>
                                                        <span id="debt" class="info-value"></span>
                                                    </div>
                                                    <div class="info-row">
                                                        <span class="info-label"><strong>Supplier:</strong></span>
                                                        <span id="supplier_name" class="info-value"></span>
                                                    </div>
                                                    <div class="info-row">
                                                        <span class="info-label"><strong>Status Transaksi:</strong></span>
                                                        <div id="status"></div>
                                                    </div>
                                                    <div class="info-row" id="kembalian_info">
                                                        <span class="info-label"><strong>Kembalian:</strong></span>
                                                        <span id="kembalian" class="info-value"></span>
                                                    </div>
                                                    <div class="info-row">
                                                        <span id="cicil_hutang_label"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" id="button-cicil" hidden class="btn btn-warning">Cicil</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Supplier</th>
                                            <th>Hutang</th>
                                            <th>Status</th>
                                            <th>Dibuat tanggal</th>
                                            <th>Diperbarui tanggal</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($content as $data): ?>
                                            <tr>
                                                <td><?= $data['supplier'] ?></td>
                                                <td><?= number_to_currency($data['hutang'], 'IDR') ?></td>
                                                <td>
                                                    <?php if($data['status'] == 'lunas'): ?>
                                                        <span class="badge badge-success"><?= $data['status'] ?></span>
                                                    <?php else: ?>
                                                        <span class="badge badge-danger"><?= $data['status'] ?></span>
                                                    <?php endif ?>
                                                </td>
                                                <td><?= $data['created_at'] ?></td>
                                                <td><?= $data['updated_at'] ?></td>
                                                <td>
                                                    <button onclick="showDetails('<?= $data['id'] ?>')" class="btn btn-primary btn-sm mr-2">
                                                        <i class="fas fa-eye"></i> Detail Transaksi
                                                    </button>
                                                    <button onclick="deleteData(<?= $data['id'] ?>)" class="btn btn-danger btn-sm">
                                                        <i class="fas fa-trash"></i> Hapus
                                                    </button>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script src="<?= base_url('assets/js/Hutang.js') ?>"></script>
<script>
    function formatRupiah(value) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
    }
  function addToTable() {
    // Get form field values
    var nameInput = document.querySelector('input[name="name"]');
    var valueName = nameInput.value;

    if (valueName.trim() === '') {
        alert('Isi nama item/barang.');
        return;
    }

    var price = document.querySelector('input[name="price"]').value;
    var quantity = document.querySelector('input[name="quantity"]').value;
    var unit = document.querySelector('select[name="unit"]').value;
    var subtotal = document.querySelector('input[name="subtotal"]').value;

    // Create a new table row
    var newRow = document.createElement('tr');
    // Create table cells and populate them with form field values
    var nameCell = document.createElement('td');
    nameCell.textContent = valueName;
    newRow.appendChild(nameCell);

    var priceCell = document.createElement('td');
    priceCell.textContent = formatRupiah(price);
    newRow.appendChild(priceCell);

    var quantityCell = document.createElement('td');
    quantityCell.textContent = quantity;
    newRow.appendChild(quantityCell);

    var unitCell = document.createElement('td');
    unitCell.textContent = unit;
    newRow.appendChild(unitCell);

    var subtotalCell = document.createElement('td');
    subtotalCell.textContent = formatRupiah(subtotal);
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
    document.querySelector('input[name="name"]').value = '';
    document.querySelector('input[name="price"]').value = '';
    document.querySelector('input[name="quantity"]').value = '';
    document.querySelector('select[name="unit"]').value = '';
    document.querySelector('input[name="subtotal"]').value = '';

    updateTotal(); // Update the total after adding the new row
  }


  function updateTotal() {
    var tableRows = document.querySelectorAll('#tableBody tr');
    var total = 0;

    tableRows.forEach(function(row) {
        var subtotalCell = row.querySelector('td:nth-child(5)');
        var subtotalText = subtotalCell.textContent.trim().replace(/[^\d,-]/g, '').replace(',', '.');
        var subtotal = parseFloat(subtotalText);
        console.log(subtotal);

        if (!isNaN(subtotal)) {
        total += subtotal;
        }
    });

    var totalCell = document.getElementById('total');
    totalCell.textContent = formatRupiah(total);
    totalCell.dataset.value = total;
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
    if (formData.size === 0) {
        alert('Form data is empty.');
        return;
    }
    // Get the table rows
    var tableRows = document.querySelectorAll('#tableBody tr');

    // Iterate over each row and extract the data
    var names = [];
    var stock = [];
    var purchase_price = [];
    var unit = [];
    tableRows.forEach(function(row) {
      var cells = row.querySelectorAll('td');
      names.push(cells[0].textContent); // Assuming the first cell contains the ID
      stock.push(cells[2].textContent); // Assuming the third cell contains the quantity
      unit.push(cells[3].textContent);
      purchase_price.push(cells[4].textContent); // Assuming the fifth cell contains the subtotal
    });

    var regularNumbers = [];

    // Convert and remove trailing zeros for each Rupiah value in purchase_price array
    purchase_price.forEach(function(price) {
    var regularNumber = parseInt(price.replace(/[^\d]/g, ''));
    var numberWithoutZeros = regularNumber / 100;
    regularNumbers.push(numberWithoutZeros);
    });

    console.log(regularNumbers);
    // Get the payment_type and user_id values
    var Supplier = document.getElementById('supplier').value;
    var totalElement = document.getElementById('total');
    var rupiahValue = totalElement.textContent;
    var regularNumber = parseInt(rupiahValue.replace(/[^0-9]+/g, ''));
    var total = parseInt(regularNumber.toString().slice(0, -2));
    console.log(total);

    if (!supplier) {
        alert('Supplier value is null or empty.');
        return;
    }


    // Add the payment_type, user_id, id_items, stock, total_prices to the form data
    formData.append('total', total);
    formData.append('supplier', Supplier);
    names.forEach(function(name, index) {
      formData.append('name[]', name);
      formData.append('quantity[]', stock[index]);
      formData.append('unit[]', unit[index]);
      formData.append('purchase_price[]', regularNumbers[index]);
    });

    // Send the POST request
    fetch(`${base_url}dashboard/hutang/supplier`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status) {
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
</script>
<?= $this->endSection() ?>