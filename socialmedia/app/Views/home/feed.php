<?= view('layouts/header', ['title' => $title ?? 'Feed']) ?>
<?= view('layouts/navbar') ?>

<main class="app-shell container">
    <aside class="left-sidebar">
        <div class="profile-mini">
            <img src="<?= profile_picture_url(session()->get('profile_picture')) ?>" alt="">
            <h2><?= e_text(session()->get('username')) ?></h2>
            <p><?= e_text(session()->get('first_name')) ?></p>
            <div class="mini-stats">
                <a href="<?= base_url('profile/' . session()->get('user_id') . '/followers') ?>"><strong><?= $followersCount ?></strong><span>Followers</span></a>
                <a href="<?= base_url('profile/' . session()->get('user_id') . '/following') ?>"><strong><?= $followingCount ?></strong><span>Following</span></a>
            </div>
        </div>
        <nav class="side-nav">
            <a class="active" href="<?= base_url('feed') ?>">News Feed</a>
            <a href="<?= base_url('profile/' . session()->get('user_id')) ?>">My Profile</a>
            <a href="<?= base_url('profile/edit') ?>">Edit Profile</a>
            <a href="<?= base_url('search') ?>">Find Tech People</a>
        </nav>
    </aside>

    <section class="feed-column">
        <form id="createPostForm" class="composer-card">
            <textarea name="content" class="form-control" rows="3" maxlength="1000" placeholder="Ask a tech question or share an innovation..." required></textarea>
            <div class="d-flex justify-content-between align-items-center mt-3">
                <small class="text-muted">Talk about devices, code, AI, apps, hardware, or tech news.</small>
                <button type="submit" class="btn btn-primary">
                    <span class="spinner-border spinner-border-sm d-none"></span>
                    Post
                </button>
            </div>
        </form>

        <div id="feedPosts">
            <?php if (empty($posts)): ?>
                <div class="empty-state">No tech posts yet. Start the first discussion.</div>
            <?php endif; ?>

            <?php foreach ($posts as $post): ?>
                <article class="post-card" data-post-id="<?= $post['id'] ?>">
                    <div class="post-header">
                        <div class="d-flex align-items-center gap-3">
                            <a href="<?= base_url('profile/' . $post['user_id']) ?>">
                                <img src="<?= profile_picture_url($post['profile_picture']) ?>" alt="">
                            </a>
                            <div>
                                <a class="post-author" href="<?= base_url('profile/' . $post['user_id']) ?>"><?= e_text($post['username']) ?></a>
                                <div class="post-time"><?= short_date($post['created_at']) ?></div>
                            </div>
                        </div>
                        <?php if ((int) $post['user_id'] === (int) session()->get('user_id')): ?>
                            <button class="btn btn-outline-danger btn-sm delete-post-btn" data-id="<?= $post['id'] ?>">Delete</button>
                        <?php endif; ?>
                    </div>
                    <p class="post-content"><?= nl2br(e_text($post['content'])) ?></p>
                    <div class="post-actions">
                        <button class="btn btn-light btn-sm like-btn" data-id="<?= $post['id'] ?>">Like <span><?= $post['likes_count'] ?></span></button>
                        <button class="btn btn-light btn-sm comment-toggle">Comment</button>
                        <button class="btn btn-light btn-sm share-btn">Share</button>
                    </div>
                    <div class="comments-box">
                        <?php foreach ($post['comments'] as $comment): ?>
                            <div class="comment-item">
                                <img src="<?= profile_picture_url($comment['profile_picture']) ?>" alt="">
                                <p><strong><?= e_text($comment['username']) ?></strong> <?= e_text($comment['comment']) ?></p>
                            </div>
                        <?php endforeach; ?>
                        <form class="comment-form mt-2" data-id="<?= $post['id'] ?>">
                            <input type="text" name="comment" class="form-control form-control-sm" maxlength="300" placeholder="Write a comment">
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </section>

    <aside class="right-sidebar">
        <h3>Suggested Users</h3>
        <?php if (empty($suggestedUsers)): ?>
            <p class="text-muted small">You are already following everyone suggested.</p>
        <?php endif; ?>
        <?php foreach ($suggestedUsers as $user): ?>
            <div class="suggested-user">
                <a href="<?= base_url('profile/' . $user['id']) ?>">
                    <img src="<?= profile_picture_url($user['profile_picture']) ?>" alt="">
                    <span><?= e_text($user['username']) ?></span>
                </a>
                <button class="btn btn-outline-primary btn-sm follow-btn" data-user-id="<?= $user['id'] ?>">Follow</button>
            </div>
        <?php endforeach; ?>
    </aside>
</main>

<?= view('layouts/footer') ?>
