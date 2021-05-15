<!DOCTYPE html>
<html lang="en">

<head>
    <?php $this->load->view('admin/layout/_head') ?>
</head>

<body class="c-app flex-row align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="card-group">
                    <div class="card p-4">
                        <div class="card-body">
                            <form autocomplete="off" method="POST" action="<?= base_url('login/auth') ?>">
                                <h1>Login</h1>
                                <p class="text-muted">Sign In to your account</p>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="c-icon cil-user"></i> 
                                        </span>
                                    </div>
                                    <input name="UserName" class="form-control" type="text" placeholder="Username">
                                </div>
                                <div class="input-group mb-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">
                                            <i class="c-icon cil-lock-locked"></i>
                                        </span>
                                    </div>
                                    <input name="Password" class="form-control" type="password" placeholder="Password">
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <button type="submit" class="btn btn-primary px-4" type="button">Login</button>
                                    </div>
                                    <div class="col-6 text-right">
                                        
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('admin/layout/_scripts') ?>
    <?php $this->load->view('admin/layout/_msg') ?>
</body>

</html>