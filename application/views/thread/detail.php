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
        <h2>タイトル</h2>
        <p class="lead">概要概要概要概要概要概要概要概要概要概要概要概要</p>
    </div>
    <div class="card mb-5">
        <div class="list-group">
            <div class="list-group-item list-group-item-action ">
                <div class="mb-4 d-flex">
                    <div class="flex-grow-1">
                        <small class="me-3">投稿者： 椛澤</small>
                        <small>投稿日時: 2023-04-17</small>
                    </div>
                    <a class="btn btn-outline-danger btn-sm">削除</a>
                </div>
                <p class="">概要概要概要概要概要概要概要概要概要</p>
            </div>
            <div class="list-group-item list-group-item-action ">
                <div class="mb-4 d-flex">
                    <div class="flex-grow-1">
                        <small class="me-3">投稿者： 椛澤</small>
                        <small>投稿日時: 2023-04-17</small>
                    </div>
                    <a class="btn btn-outline-danger btn-sm">削除</a>
                </div>
                <p class="">概要概要概要概要概要概要概要概要概要</p>
            </div>
            <div class="list-group-item list-group-item-action ">
                <div class="mb-4 d-flex">
                    <div class="flex-grow-1">
                        <small class="me-3">投稿者： 椛澤</small>
                        <small>投稿日時: 2023-04-17</small>
                    </div>
                    <a class="btn btn-outline-danger btn-sm">削除</a>
                </div>
                <p class="">概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要</p>
            </div>
            <div class="list-group-item list-group-item-action ">
                <div class="mb-4 d-flex">
                    <div class="flex-grow-1">
                        <small class="me-3">投稿者： 椛澤</small>
                        <small>投稿日時: 2023-04-17</small>
                    </div>
                    <a class="btn btn-outline-danger btn-sm">削除</a>
                </div>
                <p class="">概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要<br>概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要概要</p>
            </div>
            <div class="list-group-item list-group-item-action ">
                <div class="mb-4 d-flex">
                    <div class="flex-grow-1">
                        <small class="me-3">投稿者： 椛澤</small>
                        <small>投稿日時: 2023-04-17</small>
                    </div>
                    <a class="btn btn-outline-danger btn-sm">削除</a>
                </div>
                <p class="">概要概要概要概要概要概要概要概要概要</p>
            </div>
            <div class="list-group-item list-group-item-action ">
                <div class="mb-4 d-flex">
                    <div class="flex-grow-1">
                        <small class="me-3">投稿者： 椛澤</small>
                        <small>投稿日時: 2023-04-17</small>
                    </div>
                    <a class="btn btn-outline-danger btn-sm">削除</a>
                </div>
                <p class="">概要概要概要概要概要概要概要概要概要</p>
            </div>
        </div>
    </div>
    <hr />
    <div class="card">
        <div class="card-body">
            <form action="" method="post">
                <div class="mb-3">
                    <label for="" class="form-label fw-bold">メッセージ</label>
                    <textarea class="form-control" id="" rows="3"></textarea>
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