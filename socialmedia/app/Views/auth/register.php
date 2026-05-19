<?= view('layouts/header', ['title' => $title ?? 'Register']) ?>

<main class="auth-page">
    <section class="auth-card auth-card-wide">
        <div class="mb-4">
            <h1>Create TechSpace account</h1>
            <p>Join a modern tech community for posts about gadgets, apps, coding, AI, and new innovations.</p>
        </div>

        <?php if (isset($validation)): ?>
            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>

        <form action="<?= base_url('register') ?>" method="post">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" name="username" class="form-control" value="<?= old('username') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?= old('first_name') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?= old('last_name') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="birth_date" class="form-control" value="<?= old('birth_date') ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Sex</label>
                    <select name="sex" class="form-select" required>
                        <option value="">Select</option>
                        <?php foreach (['Male', 'Female', 'Other'] as $sex): ?>
                            <option value="<?= $sex ?>" <?= old('sex') === $sex ? 'selected' : '' ?>><?= $sex ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" name="password" class="form-control" minlength="6" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Confirm Password</label>
                    <input type="password" name="confirm_password" class="form-control" minlength="6" required>
                </div>
            </div>
            <button type="submit" class="btn btn-primary w-100">Register</button>
        </form>

        <p class="text-center mt-4 mb-0">Already registered? <a href="<?= base_url('login') ?>">Login</a></p>
    </section>
</main>

<?= view('layouts/footer') ?>
