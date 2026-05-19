<nav class="navbar navbar-expand-lg navbar-dark tech-navbar sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="<?= base_url('feed') ?>">TechSpace</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <form class="mx-lg-auto my-3 my-lg-0 search-box" action="<?= base_url('search') ?>" method="get">
                <input class="form-control" id="navSearch" type="search" name="q" placeholder="Search tech people" autocomplete="off">
                <div id="searchSuggestions" class="search-suggestions"></div>
            </form>

            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item">
                    <a class="nav-link <?= active_nav('feed') ?>" href="<?= base_url('feed') ?>">Feed</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= active_nav('search') ?>" href="<?= base_url('search') ?>">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?= str_contains(uri_string(), 'profile') ? 'active' : '' ?>" href="<?= base_url('profile/' . session()->get('user_id')) ?>">
                        <img src="<?= profile_picture_url(session()->get('profile_picture')) ?>" class="nav-avatar" alt="">
                        <?= e_text(session()->get('username')) ?>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="btn btn-outline-danger btn-sm" href="<?= base_url('logout') ?>">Logout</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
