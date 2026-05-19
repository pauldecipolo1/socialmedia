<?= view('layouts/header', ['title' => 'Page Not Found']) ?>
<main class="auth-page">
    <section class="auth-card text-center">
        <h1>404</h1>
        <p>The page you are looking for does not exist.</p>
        <a class="btn btn-primary" href="<?= base_url('feed') ?>">Back to Feed</a>
    </section>
</main>
<?= view('layouts/footer') ?>
