<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= e_text($title ?? 'SocialMedia') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?= base_url('assets/css/style.css') ?>">
    <script>
        window.AppConfig = {
            baseUrl: "<?= rtrim(base_url(), '/') ?>",
            defaultAvatar: "<?= profile_picture_url('default.png') ?>"
        };
    </script>
</head>
<body>
<div class="toast-container position-fixed top-0 end-0 p-3">
    <div id="appToast" class="toast align-items-center border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body"></div>
            <button type="button" class="btn-close me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<?php if (session()->getFlashdata('success') || session()->getFlashdata('error')): ?>
    <div class="server-flash d-none"
         data-type="<?= session()->getFlashdata('success') ? 'success' : 'error' ?>"
         data-message="<?= e_text(session()->getFlashdata('success') ?: session()->getFlashdata('error')) ?>"></div>
<?php endif; ?>
