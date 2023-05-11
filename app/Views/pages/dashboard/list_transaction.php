<?= $this->extend('layout/templateDashboard') ?>
<?= $this->section('content') ?>  

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Transaksi</h6>
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
                                        <button type="button" id="button-bayar" hidden class="btn btn-warning">Bayar</button>
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
                                            <th>Metode Pembayaran</th>
                                            <th>Total</th>
                                            <th>Status</th>
                                            <th>Waktu Transaksi</th>
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
                                                    'payment_type' => $data['payment_type'],
                                                    'total_price' => $data['total_price'],
                                                    'status' => $data['status'],
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
                                                <td>
                                                <?php if($data['payment_type'] == 'hutang'): ?>
                                                    <span class="badge badge-warning">Hutang</span>
                                                <?php else: ?>
                                                    <span class="badge badge-primary"><?= $data['payment_type'] ?></span>
                                                <?php endif ?>
                                                </td>
                                                <?php if($data['total_price'] == NULL): ?>
                                                    <td><?= $data['total_price'] ?></td>
                                                <?php else: ?>
                                                    <td><?= number_to_currency($data['total_price'], 'IDR') ?></td>
                                                <?php endif ?>
                                                <td>
                                                    <?php if($data['status'] == 'no_payment'): ?>
                                                        <span class="badge badge-danger">Belum Bayar</span>
                                                    <?php elseif($data['status'] == 'half'): ?>
                                                        <span class="badge badge-warning">Bayar Setengah</span>
                                                    <?php else: ?>
                                                        <span class="badge badge-success">Lunas</span>
                                                    <?php endif ?>
                                                </td>
                                                <td><?= $data['created_at'] ?></td>
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
<script>
    function printModal() {
        var transactionCode = document.getElementById("kode_transaksi").textContent.trim();
        var printContents = document.getElementById("form").querySelector("table").outerHTML;

        // Konversi konten menjadi file PDF dan unduh
        var fileName = transactionCode + ".pdf";
        var pdf = new jsPDF();
        pdf.setFontSize(14);
        pdf.text("Struk Pembayaran", 70, 20, null, null, "center");
        pdf.setFontSize(12);
        pdf.text("Kode Transaksi: " + transactionCode, 20, 40);
        pdf.fromHTML(printContents, 15, 60);
        pdf.setFontSize(14);
        pdf.text("Terima kasih telah berbelanja", 70, pdf.internal.pageSize.height - 20, null, null, "center");
        pdf.save(fileName);
    }
</script>
<?= $this->endSection() ?>