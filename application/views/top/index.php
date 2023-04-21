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
                    <?php if($this->user->is_login()){ ?>
                    <a class="btn btn-secondary" href="<?php echo site_url('thread/post') ?>">新規スレッド作成</a>
                    <?php } ?>
                </div>
                <div class="list-group">
                    <?php foreach ($this->thread->get_items() AS $num => $item) { $this->thread->set_item($item); ?>
                    <a href="<?php echo site_url('thread/detail/'.$this->thread->extract_item('no')) ?>" class="list-group-item list-group-item-action">
                        <div class="d-flex w-100 justify-content-between">
                            <h5 class="mb-1"><?php echo $this->thread->extract_item('title') ?></h5>
                            <?php if($this->thread->extract_item('last_message_author_name')) {?>
                            <small>最終投稿: <?php echo date('Y-m-d H:i:s', strtotime($this->thread->extract_item('last_message_created_date'))) ?><br>最終投稿者：　<?php echo $this->thread->extract_item('last_message_author_name') ?></small>
                            <?php } ?>
                        </div>
                        <p class="mb-1"><?php echo $this->thread->extract_item('description') ?>　</p>
                        <small>作成者： <?php echo $this->thread->extract_item('author_name') ?></small>
                    </a>
                    <?php } ?>
                </div>
            </div>
        </main>
    </body>
</html>