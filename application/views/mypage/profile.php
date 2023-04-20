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
        <h2>プロフィール</h2>
    </div>
    <div class="">
        <?php echo $this->user->get_message() ?>
        <div class="card">
            <div class="card-body">
                <form id="myform" action="" method="post">
                    <div class="mb-3"><?php $id = 'name' ?>
                        <label for="" class="form-label fw-bold">名前<small class="text-danger">(必須)</small></label>
                        <input type="text" class="form-control" id="" name="<?php echo $this->user->get_prefix().$id ?>" value="<?php echo set_value($this->user->get_prefix().$id, $this->user->get_login_user($id)) ?>">
                        <?php echo form_error($this->user->get_prefix().$id); ?>
                    </div>
                    <div class="mb-3"><?php $id = 'email' ?>
                        <label for="" class="form-label fw-bold">メールアドレス<small class="text-danger">(必須)</small></label>
                        <input type="email" class="form-control" id="" name="<?php echo $this->user->get_prefix().$id ?>" value="<?php echo set_value($this->user->get_prefix().$id, $this->user->get_login_user($id)) ?>">
                        <?php echo form_error($this->user->get_prefix().$id); ?>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-success">登録</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
</body>
</html>