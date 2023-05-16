<?= $this->extend('layout/templateDashboard') ?>
<?= $this->section('content') ?>  

                    <div class="card shadow mb-4">
                        <div class="card-header py-3 d-flex justify-content-between align-items-center">
                            <h6 class="m-0 font-weight-bold text-primary">Data Hutang</h6>
                            <div>
                                <button class="btn btn-success" data-toggle="modal" data-target="#dateRangeModal">Export to Excel</button>
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
                                                <label for="startDate">Start Date</label>
                                                <input type="date" class="form-control" id="startDate" name="startDate">
                                            </div>
                                            <div class="form-group">
                                                <label for="endDate">End Date</label>
                                                <input type="date" class="form-control" id="endDate" name="endDate">
                                            </div>
                                                <div class="form-group">
                                                    <label for="status">Status</label>
                                                    <select class="form-control" id="status" name="status">
                                                        <option value="">All</option>
                                                        <option value="lunas">Lunas</option>
                                                        <option value="cicil">Cicil</option>
                                                    </select>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Export</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- Button trigger modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                        Tambah Hutang
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h4 class="modal-title" id="myModalLabel">Tambah Hutang</h4>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="form">
                                            <div class="form-group">
                                                <label for="inputName">Supplier</label>
                                                <input type="text" class="form-control" id="supplier" name="supplier" placeholder="Masukkan supplier">
                                            </div>
                                            <div class="form-group">
                                                <label for="inputName">Hutang</label>
                                                <input type="number" class="form-control" id="hutang" name="hutang" placeholder="Masukkan jumlah hutang">
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
                                                        <span id="status" class="info-value"></span>
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
                                            <th>Cicil</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th>Updated At</th>
                                            <th>Opsi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($content as $data): ?>
                                            <tr>
                                                <td><?= $data['supplier'] ?></td>
                                                <td><?= number_to_currency($data['hutang'], 'IDR') ?></td>
                                                <td><?= number_to_currency($data['cicil'], 'IDR')?></td>
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
<?= $this->endSection() ?>