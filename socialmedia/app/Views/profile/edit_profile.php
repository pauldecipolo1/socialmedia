<?= view('layouts/header', ['title' => $title ?? 'Edit Profile']) ?>
<?= view('layouts/navbar') ?>

<main class="container py-4">
    <section class="form-panel">
        <h1>Edit Profile</h1>
        <p class="text-muted">Your username cannot be changed.</p>

        <?php if (isset($validation)): ?>
            <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
        <?php endif; ?>

        <form action="<?= base_url('profile/update') ?>" method="post" enctype="multipart/form-data">
            <div class="avatar-edit">
                <img id="imagePreview" src="<?= profile_picture_url($user['profile_picture']) ?>" alt="">
                <div>
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="profile_picture" id="profilePictureInput" class="form-control" accept=".jpg,.jpeg,.png">
                    <small class="text-muted">JPG, JPEG, or PNG. Maximum 2MB.</small>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Username</label>
                    <input type="text" class="form-control" value="<?= e_text($user['username']) ?>" disabled>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" value="<?= old('email', $user['email']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">First Name</label>
                    <input type="text" name="first_name" class="form-control" value="<?= old('first_name', $user['first_name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Last Name</label>
                    <input type="text" name="last_name" class="form-control" value="<?= old('last_name', $user['last_name']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Date of Birth</label>
                    <input type="date" name="birth_date" class="form-control" value="<?= old('birth_date', $user['birth_date']) ?>" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Sex</label>
                    <select name="sex" class="form-select" required>
                        <?php foreach (['Male', 'Female', 'Other'] as $sex): ?>
                            <option value="<?= $sex ?>" <?= old('sex', $user['sex']) === $sex ? 'selected' : '' ?>><?= $sex ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Bio / About</label>
                    <textarea name="bio" class="form-control" rows="4" maxlength="500"><?= e_text(old('bio', $user['bio'])) ?></textarea>
                </div>
            </div>

            <button class="btn btn-primary" type="submit">Save Changes</button>
            <a class="btn btn-light" href="<?= base_url('profile/' . session()->get('user_id')) ?>">Cancel</a>
        </form>
    </section>
</main>

<?= view('layouts/footer') ?>
