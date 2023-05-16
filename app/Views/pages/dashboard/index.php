<?= $this->extend('layout/templateDashboard') ?>
<?= $this->section('content') ?>  

                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-primary shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                Jumlah Barang</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_barang ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-calendar fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-success shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                Jumlah Kasir</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_kasir ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-info shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Jumlah Transaksi
                                            </div>
                                            <div class="row no-gutters align-items-center">
                                                <div class="col-auto">
                                                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?= $jumlah_transaksi ?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Pending Requests Card Example -->
                        <div class="col-xl-3 col-md-6 mb-4">
                            <div class="card border-left-warning shadow h-100 py-2">
                                <div class="card-body">
                                    <div class="row no-gutters align-items-center">
                                        <div class="col mr-2">
                                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                                Jumlah Pengguna</div>
                                            <div class="h5 mb-0 font-weight-bold text-gray-800"><?= $jumlah_pengguna ?></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Profile Toko</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inputNamaToko">Nama Toko</label>
                                        <input name="nama_toko" type="text" class="form-control" id="inputNamaToko" placeholder="Enter Nama Toko" value="<?= $data_toko['nama_toko'] ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputNamaPemilik">Nama Pemilik</label>
                                        <input name="nama_pemilik" type="text" class="form-control" id="inputNamaPemilik" placeholder="Enter Nama Pemilik" value="<?= $data_toko['nama_pemilik'] ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputNomorTelepon">Nomor Telepon</label>
                                        <input name="nomor_telepon" type="number" class="form-control" id="inputNomorTelepon" placeholder="Nomor Telepon" value="<?= $data_toko['nomor_telepon'] ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleFormControlTextarea1">Alamat</label>
                                        <input name="alamat" class="form-control" value="<?= $data_toko['alamat'] ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>User Sedang Login</h4>
                                </div>
                                <div class="card-body">
                                    <div class="form-group">
                                        <label for="inputNamaToko">Nama</label>
                                        <input type="text" class="form-control" id="inputNamaToko" placeholder="Enter Nama Toko" value="<?= session()->get('name') ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputNamaPemilik">Username</label>
                                        <input type="text" class="form-control" id="inputNamaPemilik" placeholder="Enter Nama Pemilik" value="<?= session()->get('username') ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputNomorTelepon">Role</label>
                                        <input class="form-control" id="inputNomorTelepon" placeholder="Nomor Telepon" value="<?= session()->get('role') ?>" disabled>
                                    </div>
                                    <div class="form-group">
                                        <label for="inputNomorTelepon">Waktu Login</label>
                                        <input class="form-control" id="inputNomorTelepon" placeholder="Nomor Telepon" value="<?= session()->get('login_time') ?>" disabled>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

<?= $this->endSection() ?>