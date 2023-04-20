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
        <h2><?php echo $this->thread->extract_item('title') ?></h2>
        <p class="lead"><?php echo $this->thread->extract_item('description') ?></p>
    </div>
    <?php echo $this->message->get_message() ?>
    <div class="card mb-5">
        <div class="list-group">
            <?php foreach ($this->message->get_thread_items() AS $item){ $this->message->set_item($item) ?>
            <div class="list-group-item list-group-item-action ">
                <div class="mb-4 d-flex">
                    <div class="flex-grow-1">
                        <small class="me-3">投稿者： <?php echo $this->message->extract_item('author_name') ?></small>
                        <small>投稿日時: <?php echo date('Y-m-d H:i:s') ?></small>
                    </div>
                    <?php if($this->message->has_author()){ ?>
                    <?php //todo 本当はJavascriptをトリガーにしたい  ?>
                    <a class="btn btn-outline-danger btn-sm" href="<?php echo site_url("{$this->view_dir}delete_message/{$this->thread->get_itemNo()}/{$this->message->extract_item('no')}") ?>">削除</a>
                    <?php } ?>
                </div>
                <p class=""><?php echo nl2br($this->message->extract_item('text')) ?></p>
            </div>
            <?php } ?>
        </div>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <form action="<?php echo site_url($this->view_dir.'add_message/'.$this->thread->get_itemNo()) ?>" method="post">
                <div class="mb-3"><?php $id="text" ?>
                    <label for="" class="form-label fw-bold">メッセージ</label>
                    <textarea class="form-control" id="" rows="3" name="<?php echo $this->message->get_prefix() . $id ?>" value=""></textarea>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-success">投稿する</button>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>