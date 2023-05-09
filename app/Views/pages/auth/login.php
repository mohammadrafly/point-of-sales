<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Penjualan App | <?= $title ?></title>

    <link href="<?= base_url('assets/vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="<?= base_url('assets/css/sb-admin-2.min.css') ?>" rel="stylesheet">
</head>
<body class="bg-gradient-primary">
    <div class="container">

        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Login</h1>
                                        <?php if(session()->has('error')): ?>
                                            <div class="alert alert-danger"><?= session('error') ?></div>
                                        <?php endif; ?>
                                    </div>
                                    <form id="SignIn">
                                        <div class="form-group">
                                            <input name="username" id="username" type="text" class="form-control form-control-user" placeholder="Enter Username/Email">
                                        </div>
                                        <div class="form-group">
                                            <input name="password" id="password" type="password" class="form-control form-control-user" placeholder="Password">
                                        </div>
                                        <button type="submit" class="btn btn-primary btn-user btn-block">
                                            Sign In
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>
    <script src="<?= base_url('assets/js/Main.js') ?>"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function() {
            $('#SignIn').submit(function(event) {
                event.preventDefault();

                var formData = $(this).serialize();

                $.ajax({
                    type: 'POST',
                    url: `${base_url}login`,
                    data: formData,
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            var role = response.role;
                            switch (role) {
                                case 'admin':
                                    window.location.href = `${base_url}dashboard`;
                                    break;
                                default:
                                    window.location.href = `${base_url}`;
                                    break;
                            }
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('An error occurred while processing your request.');
                    }
                });
            });
        });
    </script>
</body>
</html>