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
                <h2>掲示板</h2>
            </div>
            <div class="">
                <div class="text-end mb-3">
                    <a class="btn btn-secondary" href="<?php echo site_url('thread/post') ?>">新規スレッド作成</a>
                </div>
                <div class="list-group">
                    <?php foreach ([1,1,1,1,1,1,1,1] AS $num => $item) { ?>
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1">タイトル<?php echo $num ?></h5>
                            <small>最終投稿: 2023-04-17<br>最終投稿者：　椛澤</small>
                        </div>
                        <p class="mb-1">概要概要概要概要概要概要概要概要概要</p>
                        <small>作成者： 椛澤</small>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </main>
    </body>
</html>