<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Gentelella Alela! | </title>

    <!-- Bootstrap -->
    <link href="<?= base_url('assets/admin/vendors/bootstrap/dist/css/bootstrap.min.css') ?>" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?= base_url('assets/admin/vendors/font-awesome/css/font-awesome.min.css') ?>" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?= base_url('assets/admin/vendors/nprogress/nprogress.css') ?>" rel="stylesheet">
    <!-- Animate.css -->
    <link href="<?= base_url('assets/admin/vendors/animate.css/animate.min.css') ?>" rel="stylesheet">

    <!-- Custom Theme Style -->
    <link href="<?= base_url('assets/admin/css/custom.css') ?>" rel="stylesheet">
    <style>
        html,
        body {
            height: 0;
        }

        .login_wrapper {
            right: 0px;
            margin: 0px auto;
            /* margin-top: 5%; */
            /* max-width: 350px; */
            width: 100vw;
            justify-content: center;
            align-items: center;
            height: 100vh;
            /* position: relative; */
            display: flex;
        }

        .registration_form,
        .login_form {
            position: static;
            /* top: 0px; */
            /* width: 100%; */
        }

        .login_content{
            margin: 0;
            padding: 0;
        }
    </style>
    <script src="<?= base_url('assets/admin/js/sweetalert2.js') ?>"></script>
</head>

<body class="login">
    <div>
        <a class="hiddenanchor" id="signup"></a>
        <a class="hiddenanchor" id="signin"></a>

        <div class="login_wrapper">
            <div class="animate form login_form">
                <section class="login_content">
                    <form autocomplete="off" method="POST" action="<?= base_url('admin/login/auth') ?>">
                        <h1>Login Form</h1>
                        <div>
                            <input name="UserName" type="text" class="form-control" placeholder="Username" required />
                        </div>
                        <div>
                            <input name="Password" type="password" class="form-control" placeholder="Password" required />
                        </div>
                        <div>
                            <button type="submit" class="btn btn-primary submit">Log in</button>
                        </div>

                        <div class="clearfix"></div>
                    </form>
                </section>
            </div>
        </div>
    </div>

    <?php if ($msg = $this->session->flashdata('msg')) : ?>
        <script>
            const msg = <?= json_encode($msg); ?>;

            Swal.fire({
                title: msg.title,
                icon: msg.icon,
                text: msg.text
            })
        </script>
    <?php endif ?>
</body>

</html>