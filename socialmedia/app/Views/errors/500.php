<?= view('layouts/header', ['title' => 'Server Error']) ?>
<main class="auth-page">
    <section class="auth-card text-center">
        <h1>500</h1>
        <p>Something went wrong. Please try again later.</p>
        <a class="btn btn-primary" href="<?= base_url('feed') ?>">Back to Feed</a>
    </section>
</main>
<?= view('layouts/footer') ?>
