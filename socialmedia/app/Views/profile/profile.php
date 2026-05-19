<?= view('layouts/header', ['title' => $title ?? 'Profile']) ?>
<?= view('layouts/navbar') ?>

<main class="container py-4">
    <section class="profile-cover">
        <div class="profile-main">
            <img src="<?= profile_picture_url($user['profile_picture']) ?>" alt="">
            <div>
                <h1><?= e_text($user['first_name'] . ' ' . $user['last_name']) ?></h1>
                <p>@<?= e_text($user['username']) ?></p>
                <p class="profile-bio"><?= e_text($user['bio'] ?: 'No tech bio yet.') ?></p>
            </div>
        </div>
        <div class="profile-actions">
            <?php if ($isOwnProfile): ?>
                <a class="btn btn-primary" href="<?= base_url('profile/edit') ?>">Edit Profile</a>
            <?php else: ?>
                <button class="btn btn-primary follow-btn" data-user-id="<?= $user['id'] ?>">
                    <?= $isFollowing ? 'Unfollow' : 'Follow' ?>
                </button>
            <?php endif; ?>
        </div>
    </section>

    <section class="profile-grid">
        <div class="info-card">
            <h2>About</h2>
            <p><strong>Email:</strong> <?= e_text($user['email']) ?></p>
            <p><strong>Birth Date:</strong> <?= e_text($user['birth_date']) ?></p>
            <p><strong>Sex:</strong> <?= e_text($user['sex']) ?></p>
            <div class="mini-stats mt-3">
                <a href="<?= base_url('profile/' . $user['id'] . '/followers') ?>"><strong id="followersCount"><?= $followersCount ?></strong><span>Followers</span></a>
                <a href="<?= base_url('profile/' . $user['id'] . '/following') ?>"><strong><?= $followingCount ?></strong><span>Following</span></a>
            </div>
        </div>

        <div>
            <?php if (empty($posts)): ?>
                <div class="empty-state">No posts to show.</div>
            <?php endif; ?>
            <?php foreach ($posts as $post): ?>
                <article class="post-card">
                    <div class="post-header">
                        <img src="<?= profile_picture_url($post['profile_picture']) ?>" alt="">
                        <div>
                            <div class="post-author"><?= e_text($post['username']) ?></div>
                            <div class="post-time"><?= short_date($post['created_at']) ?></div>
                        </div>
                        <?php if ((int) $post['user_id'] === (int) session()->get('user_id')): ?>
                            <button class="btn btn-outline-danger btn-sm ms-auto delete-post-btn" data-id="<?= $post['id'] ?>">Delete</button>
                        <?php endif; ?>
                    </div>
                    <p class="post-content"><?= nl2br(e_text($post['content'])) ?></p>
                </article>
            <?php endforeach; ?>
        </div>
    </section>
</main>

<?= view('layouts/footer') ?>
