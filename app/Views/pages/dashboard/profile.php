<?= $this->extend('layout/templateDashboard') ?>
<?= $this->section('content') ?>  

<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-header">
        <h4>Profile Toko</h4>
        <?php if(session()->has('error')): ?>
            <div class="alert alert-danger"><?= session('error') ?></div>
        <?php endif; ?>
        <?php if(session()->has('success')): ?>
            <div class="alert alert-success"><?= session('success') ?></div>
        <?php endif; ?>
      </div>
      <div class="card-body">
        <form action="<?= base_url('dashboard/profile-toko') ?>" method="POST">
          <div class="form-group">
            <label for="inputNamaToko">Nama Toko</label>
            <input name="nama_toko" type="text" class="form-control" id="inputNamaToko" placeholder="Enter Nama Toko" value="<?= $nama_toko ?>">
          </div>
          <div class="form-group">
            <label for="inputNamaPemilik">Nama Pemilik</label>
            <input name="nama_pemilik" type="text" class="form-control" id="inputNamaPemilik" placeholder="Enter Nama Pemilik" value="<?= $nama_pemilik ?>">
          </div>
          <div class="form-group">
            <label for="inputNomorTelepon">Nomor Telepon</label>
            <input name="nomor_telepon" type="number" class="form-control" id="inputNomorTelepon" placeholder="Nomor Telepon" value="<?= $nomor_telepon ?>">
          </div>
          <div class="form-group">
            <label for="exampleFormControlTextarea1">Alamat</label>
            <textarea name="alamat" class="form-control" id="exampleFormControlTextarea1" rows="3"><?= $alamat ?></textarea>
          </div>
          <button type="button" class="btn btn-secondary" id="edit-btn">Edit</button>
          <button type="submit" class="btn btn-primary" id="submit-btn" disabled>Submit</button>
        </form>
      </div>
    </div>
  </div>
</div>


<?= $this->endSection() ?>
<?= $this->section('script') ?>
<script>
  const editBtn = document.querySelector('#edit-btn');
  const submitBtn = document.querySelector('#submit-btn');
  const formInputs = document.querySelectorAll('#profile-form input, #profile-form textarea');

  editBtn.addEventListener('click', () => {
    formInputs.forEach(input => {
      input.disabled = !input.disabled;
    });

    editBtn.textContent = editBtn.textContent === 'Edit' ? 'Cancel' : 'Edit';
    submitBtn.disabled = !submitBtn.disabled;
  });
</script>
<?= $this->endSection() ?>