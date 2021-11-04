<?php
////ポストコントローラー////

//設定を読み込み
include_once '../config.php';
//便利な関数を読み込み
include_once '../util.php';

//ツイートデータ操作モデルを読み込み
include_once '../Models/tweets.php';


//ログインチェック
$user = getUserSession();//util.phpより用いる
if(!$user){//変数userに値がなければログインしていない事になる
    //ログインしていない
    //header関数はブラウザに命令ができる。Locationという命令は、下記にかいたURLに遷移させるという内容
    header('Location: ' . HOME_URL . 'Controllers/sign-in.php');
    exit;
}

//ツイートがある場合
if (isset($_POST['body'])){
    $image_name = null;
    //もしimageというファイルが存在して、それがアップロードされたものならば画像を保存する
    //$_FILESはアップロードされた値を取得するファイルアップロード関数。'tmp_name'はサーバー上で一時的に保存されるテンポラリファイル。
    if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])){
        $image_name = uploadImage($user, $_FILES['image'],'tweet'); //画像をアップロード
    }

    $data = [
        'user_id' => $user['id'],
        'body' => $_POST['body'],
        'image_name' => $image_name,
    ];

    //つぶやき投稿
    if(createTweet($data)){
        //ホーム画面に遷移
        header('Location: '.HOME_URL.'Controllers/home.php');
        exit;
    }
}

//表示用の変数
$view_user=$user;

//画面表示
include_once ('../Views/post.php');