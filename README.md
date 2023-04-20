# 研修用のCodeIgniterを使った掲示板

## テストサイト
http://jp111009.php.xdomain.jp/

## 初期設定
1.「index_php」を「index.php」にリネーム

2.「index.php」のENVIRONMENTへ環境に合わせた値に変更する。
~~~
define('ENVIRONMENT', isset($_SERVER['CI_ENV']) ? $_SERVER['CI_ENV'] : 'development');
~~~
~~~
・ 開発環境：development
・ 検証環境：testing
・ 本番環境：production
~~~

3.「application/config」の「config_php」「database_php」を「config.php」「database.php」に変更する

4.「config.php」の「$config['base_url']」にサイトのドメインURLを設定する
~~~
$config['base_url'] = 'https://www.hogehoge.com';
~~~

5.「database.php」にデータベースの情報を設定する。

## ユーザーの登録
1.データベースに「ユーザー」用のテーブルを作成する 

2.ユーザー登録用のページを作成する

3.ユーザー登録ページで入力した内容で登録できるようにする

4.登録したユーザーをログイン状態にする（ページ移動しても維持する）
 
5.ナビゲーションの修正（ログインしている時と表示を変える）

6.ログアウト機能をつける

7．ログイン機能を作る

8.ユーザー登録に使用できるメールアドレスは重複禁止にする

## スレッドの作成

1.データベースに「スレッド」用のテーブルを作成する

2.スレッド登録用のページを作成する

3.スレッド登録ページで入力した内容で登録できるようにする

4.スレッドを編集できるようにする

5.トップベージに全ユーザーのスレッド一覧を表示する

