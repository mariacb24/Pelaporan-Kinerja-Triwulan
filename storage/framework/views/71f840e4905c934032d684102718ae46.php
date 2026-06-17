<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Sistem Kinerja BPM</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <style>
        body { min-height: 100vh; background: linear-gradient(135deg, #1E293B 0%, #1D4ED8 100%); display: flex; align-items: center; justify-content: center; font-family: 'Segoe UI', system-ui, sans-serif; }
        .login-wrap { width: 100%; max-width: 420px; padding: 16px; }
        .login-card { border-radius: 16px; box-shadow: 0 20px 60px rgba(0,0,0,.35); border: none; }
        .logo-wrap { width: 64px; height: 64px; background: #2563EB; border-radius: 14px; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px; font-size: 24px; font-weight: 800; color: #fff; letter-spacing: -.5px; }
        .form-control { border-radius: 8px; border-color: #E2E8F0; font-size: 14px; }
        .form-control:focus { border-color: #2563EB; box-shadow: 0 0 0 3px rgba(37,99,235,.15); }
        .input-group-text { background: #F8FAFC; border-color: #E2E8F0; }
        .btn-login { background: #2563EB; border: none; border-radius: 8px; padding: .65rem 1rem; font-weight: 600; font-size: 14px; letter-spacing: .01em; }
        .btn-login:hover { background: #1D4ED8; }
        .footer-text { font-size: 11px; color: rgba(255,255,255,.5); text-align: center; margin-top: 16px; }
    </style>
</head>
<body>
<div class="login-wrap">
    <div class="card login-card p-4 p-md-5">
        <div class="text-center mb-4">
            <div class="logo-wrap">BPM</div>
            <h5 class="fw-bold mb-1">Sistem Pelaporan Kinerja</h5>
            <p class="text-muted mb-0" style="font-size:13px">Universitas Katolik Darma Cendika Surabaya</p>
        </div>

        <?php if($errors->any()): ?>
        <div class="alert alert-danger py-2 mb-3" style="font-size:13px">
            <i class="bi bi-exclamation-triangle-fill me-1"></i><?php echo e($errors->first()); ?>

        </div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('login')); ?>">
            <?php echo csrf_field(); ?>
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:13px">Email</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope text-muted" style="font-size:14px"></i></span>
                    <input type="email" name="email" class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                           value="<?php echo e(old('email')); ?>" placeholder="email@ukdc.ac.id" required autofocus>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold" style="font-size:13px">Password</label>
                <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock text-muted" style="font-size:14px"></i></span>
                    <input type="password" name="password" class="form-control" placeholder="••••••••" required>
                </div>
            </div>
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember">
                    <label class="form-check-label text-muted" for="remember" style="font-size:13px">Ingat saya</label>
                </div>
                <a href="#" class="text-primary text-decoration-none" style="font-size:13px">Lupa password?</a>
            </div>
            <button type="submit" class="btn btn-login btn-primary w-100 text-white">
                <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Sistem
            </button>
        </form>
    </div>
    <div class="footer-text">© <?php echo e(date('Y')); ?> Badan Penjaminan Mutu · Universitas Katolik Darma Cendika Surabaya</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\maria\bpm-full\resources\views/auth/login.blade.php ENDPATH**/ ?>