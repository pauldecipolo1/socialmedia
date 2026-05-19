<?php if (empty($people)): ?>
    <div class="empty-state">No users to display.</div>
<?php endif; ?>

<?php foreach ($people as $person): ?>
    <div class="person-row">
        <a href="<?= base_url('profile/' . $person['id']) ?>">
            <img src="<?= profile_picture_url($person['profile_picture']) ?>" alt="">
            <div>
                <strong><?= e_text($person['first_name'] . ' ' . $person['last_name']) ?></strong>
                <span>@<?= e_text($person['username']) ?></span>
                <p><?= e_text($person['bio'] ?: 'No bio yet.') ?></p>
            </div>
        </a>
        <?php if ($showUnfollowButton ?? false): ?>
            <button
                class="btn btn-outline-danger btn-sm follow-btn"
                data-user-id="<?= $person['id'] ?>"
                data-remove-row="true">
                Unfollow
            </button>
        <?php endif; ?>
    </div>
<?php endforeach; ?>
