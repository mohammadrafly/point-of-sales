<?= $this->extend('layout/templateDashboard') ?>
<?= $this->section('content') ?>  

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
                            <div>
                                <button class="btn btn-success" data-toggle="modal" data-target="#dateRangeModal">Export to Excel</button>
                            </div>
                        </div>
                        <!-- Date Range Modal -->
                        <div class="modal fade" id="dateRangeModal" tabindex="-1" role="dialog" aria-labelledby="dateRangeModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="dateRangeModalLabel">Select Date Range</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                <form action="<?= $tunai ? base_url('dashboard/export/tunai') :  base_url('dashboard/export/piutang'); ?>" method="post">
                                    <div class="modal-body">
                                        <!-- Date range selection inputs -->
                                        <div class="form-group">
                                            <label for="startDate">Start Date</label>
                                            <input type="date" class="form-control" id="startDate" name="startDate">
                                        </div>
                                        <div class="form-group">
                                            <label for="endDate">End Date</label>
                                            <input type="date" class="form-control" id="endDate" name="endDate">
                                        </div>
                                        <?php if (!$tunai): ?>
                                            <div class="form-group">
                                                <label for="status">Status</label>
                                                <select class="form-control" id="status" name="status">
                                                    <option value="">All</option>
                                                    <option value="done">Lunas</option>
                                                    <option value="cicil">Cicil</option>
                                                </select>
                                            </div>
                                        <?php endif; ?>
                                        <input hidden type="text" value="<?= $tunai ? 'tunai' : 'hutang' ?>" name="payment_type">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Export</button>
                                    </div>
                                </form>
                                </div>
                            </div>
                        </div>
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Detail</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body" id="form">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div style="font-weight: bold;">Waktu Transaksi: <span id="waktu" style="font-weight: normal;"></span></div>
                                                <div style="font-weight: bold;">Customer: <span id="customer" style="font-weight: normal;"></span></div>
                                                <div style="font-weight: bold;">Kode Transaksi: <span id="kode_transaksi" style="font-weight: normal;"></span></div>
                                                <div style="font-weight: bold;">Status Transaksi: <span id="status" style="font-weight: normal;"></span></div>
                                                <div style="font-weight: bold;" id="cicil_hutang_label"></div>
                                            </div>
                                        </div>
                                        <br>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <td><strong>No</strong></td>
                                                            <td><strong>Nama Barang</strong></td>
                                                            <td><strong>Harga Barang</strong></td>
                                                            <td><strong>Jumlah</strong></td>
                                                            <td><strong>Sub Total</strong></td>
                                                        </tr>
                                                    </thead>
                                                    <tbody></tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td colspan="4" align="right"><strong>Total : </strong></td>
                                                            <td><span id="total"></span></td>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="button" id="button-cicil" hidden class="btn btn-warning">Cicil</button>
                                        <button type="button" class="btn btn-primary" onclick="printModal()">Print</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode Transaksi</th>
                                            <th>Customer</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Waktu Transaksi</th>
                                            <th hidden>Payment Method</th>
                                            <th>Waktu Update</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                        // Initialize an empty array to store the merged data
                                        $merged_data = [];

                                        // Loop through each transaction data and merge the data for the same transaction code
                                        foreach ($content as $data) {
                                            $transaction_code = $data['transaction_code'];
                                            if (!isset($merged_data[$transaction_code])) {
                                                $merged_data[$transaction_code] = [
                                                    'transaction_code' => $transaction_code,
                                                    'nama_user' => $data['nama_user'],
                                                    'total_price' => $data['total_price'],
                                                    'status' => $data['status'],
                                                    'payment_type' => $data['payment_type'],
                                                    'created_at' => $data['created_at'],
                                                    'updated_at' => $data['updated_at'],
                                                    'id_items' => [$data['id_item']],
                                                    'quantities' => [$data['quantity']]
                                                ];
                                            } else {
                                                $merged_data[$transaction_code]['id_items'][] = $data['id_item'];
                                                $merged_data[$transaction_code]['quantities'][] = $data['quantity'];
                                                $merged_data[$transaction_code]['total_price'] += $data['total_price'];
                                            }
                                        }

                                        // Output the merged data in the table
                                        foreach ($merged_data as $data):
                                        ?>
                                            <tr>
                                                <td><?= $data['transaction_code'] ?></td>
                                                <td><?= $data['nama_user'] ?></td>
                                                <td><?= number_to_currency($data['total_price'], 'IDR') ?></td>
                                                <td>
                                                    <?php if($data['status'] == 'cicil'): ?>
                                                        <span class="badge badge-warning">Cicil</span>
                                                    <?php elseif ($data['status'] == 'done'): ?>
                                                        <span class="badge badge-success">Lunas</span>
                                                    <?php endif ?>
                                                </td>
                                                <td><?= $data['created_at'] ?></td>
                                                <td hidden><?= $data['payment_type'] ?></td>
                                                <td><?= $data['updated_at'] ?></td>
                                                <td>
                                                    <button onclick="showDetails('<?= $data['transaction_code'] ?>')" class="btn btn-primary btn-sm mr-2">
                                                        <i class="fas fa-eye"></i> Detail Transaksi
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
<script src="<?= base_url('assets/js/transaksi.js') ?>"></script>
<script src="https://unpkg.com/jspdf-invoice-template@1.4.0/dist/index.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.16/jspdf.plugin.autotable.min.js"></script>
<script>
    function printModal() {
        var transactionCode = document.getElementById("kode_transaksi").textContent.trim();
        var waktu = document.getElementById("waktu").textContent.trim();
        var customer = document.getElementById("customer").textContent.trim();
        var status = document.getElementById("status").textContent.trim();
        var tableRows = document.getElementById("form").querySelectorAll("table tbody tr");
        var total = document.getElementById("total").textContent.trim();

        var doc = new jsPDF();

        // Set the font size and style for the header
        doc.setFontSize(18);
        doc.setFontStyle("bold");

        // Add the transaction code as the header
        doc.text("Invoice - " + transactionCode, 20, 20);

        // Set the font size and style for the content
        doc.setFontSize(12);
        doc.setFontStyle("normal");

        // Add the transaction details
        doc.text("Waktu Transaksi: " + waktu, 20, 30);
        doc.text("Customer: " + customer, 20, 40);
        doc.text("Status Transaksi: " + status, 20, 50);

        // Set the font size and style for the table
        doc.setFontSize(12);
        doc.setFontStyle("normal");

        // Create an empty array to hold the table data
        var tableData = [];

        // Iterate over each table row and extract the cell values
        tableRows.forEach(function(row) {
            var rowData = [];
            var cells = row.querySelectorAll("td");
            cells.forEach(function(cell) {
            rowData.push(cell.textContent.trim());
            });
            tableData.push(rowData);
        });

        // Set the table options
        var tableOptions = {
            startY: 60
        };

        // Generate the table in the PDF
        doc.autoTable({
            head: [['No', 'Nama Barang', 'Harga Barang', 'Jumlah', 'Sub Total']],
            body: tableData,
            foot: [['', '', '', 'Total:', total]],
            ...tableOptions
        });
        var fileName = transactionCode + ".pdf";
        // Save the PDF document
        doc.save(fileName);
    }
</script>
<?= $this->endSection() ?>