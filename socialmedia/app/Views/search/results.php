<?= view('layouts/header', ['title' => $title ?? 'Search']) ?>
<?= view('layouts/navbar') ?>

<main class="container py-4 narrow-page">
    <section class="form-panel">
        <h1>Find Tech People</h1>
        <form action="<?= base_url('search') ?>" method="get" class="d-flex gap-2">
            <input type="search" name="q" class="form-control" value="<?= e_text($keyword) ?>" placeholder="Username, name, or email">
            <button class="btn btn-primary">Search</button>
        </form>
    </section>

    <section class="mt-4">
        <?php if ($keyword === ''): ?>
            <div class="empty-state">Search for people to follow in the tech community.</div>
        <?php elseif (empty($users)): ?>
            <div class="empty-state">No users found for "<?= e_text($keyword) ?>".</div>
        <?php endif; ?>

        <?php foreach ($users as $user): ?>
            <div class="person-row">
                <a href="<?= base_url('profile/' . $user['id']) ?>">
                    <img src="<?= profile_picture_url($user['profile_picture']) ?>" alt="">
                    <div>
                        <strong><?= e_text($user['first_name'] . ' ' . $user['last_name']) ?></strong>
                        <span>@<?= e_text($user['username']) ?></span>
                        <p><?= e_text($user['email']) ?></p>
                    </div>
                </a>
                <button class="btn btn-outline-primary btn-sm follow-btn" data-user-id="<?= $user['id'] ?>">
                    <?= $user['is_following'] ? 'Unfollow' : 'Follow' ?>
                </button>
            </div>
        <?php endforeach; ?>
    </section>
</main>

<?= view('layouts/footer') ?>
