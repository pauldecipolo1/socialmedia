<?= view('layouts/header', ['title' => $title ?? 'Login']) ?>

<main class="auth-page">
    <section class="auth-card">
        <div class="mb-4">
            <h1>Welcome to TechSpace</h1>
            <p>Login to ask questions, share tech ideas, and connect with people who enjoy devices, code, and innovation.</p>
        </div>

        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-danger"><?= e_text(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>

        <form action="<?= base_url('login') ?>" method="post">
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Login</button>
        </form>

        <p class="text-center mt-4 mb-0">No account yet? <a href="<?= base_url('register') ?>">Create one</a></p>
    </section>
</main>

<?= view('layouts/footer') ?>
