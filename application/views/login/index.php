<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>掲示板</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
<main class="container mt-5 p-5 bg-white">
    <?php $this->load->view('include/components/navi') ?>

    <div class="py-5 text-center">
        <h2>ログイン</h2>
    </div>
    <div class="">
        <div class="card mb-5">
            <div class="card-body">
                <?php echo $this->login->get_message() ?>
                <form id="myform" action="" method="post">
                    <div class="mb-3"><?php $id = $this->user->get_prefix().'email' ?>
                        <label for="" class="form-label fw-bold">メールアドレス</label>
                        <input type="email" class="form-control" id="" name="<?php echo $id ?>" value="<?php echo set_value($id) ?>">
                        <?php echo form_error($id); ?>
                    </div>
                    <div class="mb-3"><?php $id = $this->user->get_prefix().'password' ?>
                        <label for="" class="form-label fw-bold">パスワード</label>
                        <input type="password" class="form-control" id="" name="<?php echo $id ?>" value="<?php echo set_value($id) ?>">
                        <?php echo form_error($id); ?>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success" name="btn_login" value="ログイン">ログイン</button>
                    </div>
                </form>
            </div>
        </div>
        <p class="text-center">
            <a class="btn btn-primary btn-lg" href="<?php echo site_url('auth/register') ?>">新規登録の方はこちら</a>
        </p>
    </div>
</main>
</body>
</html>