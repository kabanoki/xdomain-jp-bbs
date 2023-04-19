<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo site_url() ?>">掲示板</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="<?php echo site_url() ?>">ホーム</a>
                </li>
                <?php if($this->user->is_login()){ ?>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?php echo $this->user->get_login_user('name') ?> さん
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="<?php echo site_url('auth/profile') ?>">プロフィール</a></li>
                        <li><a class="dropdown-item" href="<?php echo site_url('auth/change_password') ?>">パスワードの変更</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="<?php echo site_url('auth/logout') ?>">ログアウト</a></li>
                    </ul>
                </li>
                <?php } else { ?>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo site_url('login') ?>">ログイン</a>
                </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</nav>