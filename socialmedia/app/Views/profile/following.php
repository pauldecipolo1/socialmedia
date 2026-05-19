<?= view('layouts/header', ['title' => $title ?? 'Following']) ?>
<?= view('layouts/navbar') ?>

<main class="container py-4 narrow-page">
    <h1><?= e_text($user['username']) ?> is Following</h1>
    <?= view('profile/people_list', [
        'people' => $people,
        'showUnfollowButton' => $isOwnList ?? false,
    ]) ?>
</main>

<?= view('layouts/footer') ?>
