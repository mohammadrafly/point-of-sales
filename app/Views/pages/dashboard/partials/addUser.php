                        <div class="modal fade" id="addUser" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel">Tambah Customer</h4>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form id="form">
                                        <div class="form-group">
                                            <label for="inputName">Nama</label>
                                            <input type="text" class="form-control" id="name" name="name" placeholder="masukkan nama">
                                            <input hidden type="text" id="id" name="id">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Nomor Hp</label>
                                            <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="masukkan nomor hp">
                                        </div>
                                        <div class="form-group">
                                            <label for="inputName">Alamat</label>
                                            <textarea type="text" class="form-control" id="address" name="address"></textarea>
                                        </div>
                                        <div id="email-input" class="form-group">
                                            <label for="inputName">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" placeholder="masukkan email">
                                        </div>
                                    </form>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button onclick="saveUser()" class="btn btn-primary">Simpan</button>
                                </div>
                                </div>
                            </div>
                        </div>