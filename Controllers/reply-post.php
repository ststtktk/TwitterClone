<?php
////リプライポストコントローラー////

//設定を読み込み
include_once '../config.php';
include_once '../util.php';
include_once '../Models/tweets.php';

//ログインチェック
$user = getUserSession();
if(!$user){
    header('Location: ' . HOME_URL . 'Controllers/sign-in.php');
    exit;
}

//リプライがある場合
if (isset($_POST['reply_body'])){
    $image_name = null;
    $data = [
        'user_id' => $user['id'],
        'tweet_id'=> $_POST['tweet_id'],
        'reply_body' => $_POST['reply_body'],
    ];

    //リプライ投稿
    if(createReply($data)){
        header('Location: '.HOME_URL.'Controllers/reply.php?tweet_id='.$_POST['tweet_id']);
        exit;
    }
}

//表示用の変数
$view_user=$user;
//画面表示
include_once ('../Views/reply.php');