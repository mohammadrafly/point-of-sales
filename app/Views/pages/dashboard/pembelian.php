<?= $this->extend('layout/templateDashboard') ?>
<?= $this->section('content') ?>  

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
                                                        <span class="info-label"><strong>Harga Beli:</strong></span>
                                                        <span id="harga" class="info-value"></span>
                                                    </div>
                                                    <div class="info-row">
                                                        <span class="info-label"><strong>Stok:</strong></span>
                                                        <span id="stok" class="info-value"></span>
                                                    </div>
                                                    <div class="info-row">
                                                        <span class="info-label"><strong>Total:</strong></span>
                                                        <div id="total"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Pembelian Barang <?= $kode_barang ?></h6>
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Pembelian Barang <?= $kode_barang ?>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Pembelian Barang <?= $kode_barang ?></h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="form">
                                        <input type="text" hidden value="<?= $kode_barang ?>" id="kode_barang" name="kode_barang">
                                        <div class="form-group">
                                            <label for="inputName">Harga Beli</label>
                                            <input type="number" class="form-control" id="purchase_price" name="purchase_price" placeholder="masukkan harga beli">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Stok</label>
                                            <input type="number" class="form-control" id="stock" name="stock" placeholder="masukkan stok">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button onclick="save('<?= $kode_barang ?>')" class="btn btn-primary">Beli</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Harga Beli</th>
                                            <th>Stock</th>
                                            <th>Total</th>
                                            <th>Tanggal Pembelian</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                    foreach ($content as $data): 
                                    $total = $data['stock'] * $data['purchase_price'];   
                                        ?>
                                        <tr>
                                            <?php if($data['purchase_price'] == NULL): ?>
                                                <td><?= $data['purchase_price'] ?></td>
                                            <?php else: ?>
                                                <td><?= number_to_currency($data['purchase_price'], 'IDR') ?></td>
                                            <?php endif ?>
                                            <td><?= $data['stock'] ?></td>
                                            <td><?= number_to_currency($total, 'IDR')?></td>
                                            <td><?= $data['created_at'] ?></td>
                                            <td>
                                                <button onclick="detailData(<?= $data['id'] ?>)" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-edit"></i> Detail Pembelian
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
<script>
function save(code) {
    const form = document.getElementById('form')
    const formData = new FormData(form)
    fetch(`${base_url}dashboard/pembelian/list/detail/${code}`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert(data.message);
        location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function detailData(id) {
    $.ajax({
        url: `${base_url}dashboard/pembelian/detail/${id}`,
        type: 'GET',
        dataType: 'json',
        success: function(response) {
            const total = response.data.purchase_price * response.data.stock
            $('#waktu').text(response.data.created_at);
            $('#harga').text(formatRupiah(response.data.purchase_price));           
            $('#stok').text(response.data.stock);  
            $('#total').text(formatRupiah(total));  
            $('#detailModal').modal('show');
        },
        error: function(error) {
          console.log(error);
        }
      });
}

function formatRupiah(value) {
    return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(value);
}

$('#detailModal').on('hidden.bs.modal', function () {
    location.reload();
});
</script>
<?= $this->endSection() ?>