<?php if ($this->input->get('message') == 'unauthorized'): ?>
    <div class="alert alert-warning text-center">Please log in to access that page.</div>
<?php endif; ?>

<?php if ($this->session->flashdata('error')): ?>
    <div class="alert alert-danger text-center"><?= $this->session->flashdata('error') ?></div>
<?php endif; ?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-5">
                <div class="card shadow-sm p-4">
                    <h3 class="text-center mb-4">Login</h3>

                    <form method="post" action="<?= base_url('index.php/auth/login') ?>">
                        <div class="mb-3">
                            <label for="name" class="form-label">Username</label>
                            <input type="text" class="form-control" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="mb-3 text-center">
                            <div class="g-recaptcha" data-sitekey="6LeATB8rAAAAAHMAVwLW_SyEAH5zWLqlQxolL6tL"></div>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
