<?= view('layouts/header', ['title' => $title ?? 'Followers']) ?>
<?= view('layouts/navbar') ?>

<main class="container py-4 narrow-page">
    <h1><?= e_text($user['username']) ?>'s Followers</h1>
    <?= view('profile/people_list', ['people' => $people]) ?>
</main>

<?= view('layouts/footer') ?>
