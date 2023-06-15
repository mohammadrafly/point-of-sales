<?= $this->extend('layout/templateDashboard') ?>
<?= $this->section('content') ?>  

                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Data Barang</h6>
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Tambah Barang Baru
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Tambah Barang Baru</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="form">
                                        <div class="form-group">
                                            <label for="inputName">Nama Barang</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="masukkan nama barang">
                                            <input hidden type="text" id="id" name="id">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Deskripsi</label>
                                            <input type="text" class="form-control" id="description" name="description" placeholder="masukkan deskripsi">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Harga Jual</label>
                                            <input type="number" class="form-control" id="selling_price" name="selling_price" placeholder="masukkan harga jual">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Harga Beli</label>
                                            <input type="number" class="form-control" id="purchase_price" name="purchase_price" placeholder="masukkan harga beli">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Stok</label>
                                            <input type="number" class="form-control" id="stock" name="stock" placeholder="masukkan stok">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Satuan</label>
                                            <select class="form-control" id="unit" name="unit">
                                                <option value="KG">KILOGRAM</option>
                                                <option value="PCS">PCS</option>
                                                <option value="RENCENG">RENCENG</option>
                                                <option value="PAK">PAK</option>
                                                <option value="ONS">ONS</option>
                                            </select>
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button onclick="save()" class="btn btn-primary">Save changes</button>
                                </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Kode Barang</th>
                                            <th>Nama Barang</th>
                                            <th>Deskripsi</th>
                                            <th>Harga Jual</th>
                                            <th>Harga Beli</th>
                                            <th>Stock</th>
                                            <th>Dibuat tanggal</th>
                                            <th>Diperbarui tanggal</th>
                                            <?php if(session()->get('role') === 'admin'): ?>
                                            <th>Opsi</th>
                                            <?php endif ?> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($content as $data): ?>
                                        <tr>
                                            <td><?= $data['kode_barang'] ?></td>
                                            <td><?= $data['name'] ?></td>
                                            <td><?= $data['description'] ?></td>
                                            <?php if($data['selling_price'] == NULL): ?>
                                                <td><?= $data['selling_price'] ?></td>
                                            <?php else: ?>
                                                <td><?= number_to_currency($data['selling_price'], 'IDR') ?></td>
                                            <?php endif ?>
                                            <?php if($data['purchase_price'] == NULL): ?>
                                                <td><?= $data['purchase_price'] ?></td>
                                            <?php else: ?>
                                                <td><?= number_to_currency($data['purchase_price'], 'IDR') ?></td>
                                            <?php endif ?>
                                            <td><?= $data['stock'] ?>  <?= $data['unit'] ?></td>
                                            <td><?= $data['created_at'] ?></td>
                                            <td><?= $data['updated_at'] ?></td>
                                            <?php if (session()->get('role') === 'admin'): ?>
                                            <td>
                                                <button onclick="pembelian('<?= $data['kode_barang'] ?>')" class="btn btn-success btn-sm mr-2">
                                                    <i class="fas fa-plus"></i> Pembelian Barang
                                                </button>
                                                <button onclick="edit(<?= $data['id'] ?>)" class="btn btn-primary btn-sm mr-2">
                                                    <i class="fas fa-edit"></i> Edit
                                                </button>
                                                <button onclick="deleteData(<?= $data['id'] ?>)" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </td>
                                            <?php endif ?>
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
function pembelian(code) {
    window.location.href = `${base_url}dashboard/pembelian/list/${code}`;
}
</script>
<script src="<?= base_url('assets/js/barang.js') ?>"></script>
<?= $this->endSection() ?>