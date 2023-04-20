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
        <h2>マイページ</h2>
    </div>
    <div class="">
        <div class="text-end mb-3">
            <a class="btn btn-secondary" href="<?php echo site_url('thread/post/') ?>">新規スレッド作成</a>
        </div>
        <h5>■あなたが投稿したスレッド</h5>
        <div class="list-group">
            <?php foreach ($this->thread->get_author_items() AS $num => $item) {
                $this->thread->set_item($item);
                $this->thread->set_itemNo($item['no']);
                $this->message->set_item($this->message->get_last_thread_item());
                ?>
                <div class="list-group-item list-group-item-action">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">
                            <a class="" href="<?php echo site_url('thread/detail/'.$this->thread->extract_item('no')) ?>"><?php echo $this->thread->extract_item('title') ?></a>
                        </h5>
                        <small>最終投稿: 2023-04-17<br>最終投稿者：　椛澤</small>
                    </div>
                    <p class="mb-1"><?php echo $this->thread->extract_item('description') ?></p>
                    <small>作成者： <?php echo $this->thread->extract_item('author_name') ?></small>
                    <div class="text-end">
                        <a class="btn btn-sm btn-secondary" href="<?php echo site_url('thread/post/'.$this->thread->extract_item('no')) ?>">編集</a>
                        <?php //todo 本当はJavascriptをトリガーにしたい  ?>
                        <a class="btn btn-sm btn-outline-danger" href="<?php echo site_url($this->view_dir.'delete_thread/'.$this->thread->extract_item('no')) ?>">削除</a>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</main>
</body>
</html>