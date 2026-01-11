<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>SB Admin 2 - Login</title>

    <!-- Custom fonts for this template-->
    <!-- <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
    
    <link href="<?= base_url('vendor/fontawesome-free/css/all.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('css/sb-admin-2.min.css') ?>" rel="stylesheet">
    <link href="<?= base_url('vendor/datatables/dataTables.bootstrap4.min.css') ?>" rel="stylesheet">

    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- Custom styles for this template-->
    <!-- <link href="css/sb-admin-2.min.css" rel="stylesheet"> -->

</head>

<body class="bg-gradient-primary d-flex align-items-center justify-content-center" style="min-height:100vh;">

    <div class="container">

        <div class="col-xl-10 col-lg-12 col-md-9 mx-auto">

            <div class="card o-hidden border-0 shadow-lg">
                <div class="card-body p-0">
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                </div>

                                <form action="<?= base_url('login') ?>" method="POST" class="user">
                                <?= csrf_field() ?>

                                <div class="form-group">
                                    <input type="email"
                                        name="email"
                                        class="form-control form-control-user"
                                        placeholder="Enter Email Address..."
                                        required>
                                </div>

                                <div class="form-group">
                                    <input type="password"
                                        name="password"
                                        class="form-control form-control-user"
                                        placeholder="Password"
                                        required>
                                </div>

                                <button type="submit" class="btn btn-primary btn-user btn-block">
                                    Login
                                </button>
                            </form>


                                <hr>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</body>


</html>