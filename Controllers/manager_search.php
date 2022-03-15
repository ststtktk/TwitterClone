<?php
//////////
// 管理者用サーチコントローラー
//////////

//設定を読み込み
include_once '../config.php';
include_once '../util.php';
include_once '../Models/tweets.php';

//ログインしているか
$user = getUserSession();
if(!$user){
    header('Location:' . HOME_URL . 'Controllers/sign-in.php');
    exit;
}

// 検索キーワードを取得
$keyword = null;
if(isset($_GET['keyword'])){
    $keyword = $_GET['keyword'];
}

//表示用の変数
$view_user = $user;
$view_keyword = $keyword;
//ツイート一覧。 モデルから取得
$view_tweets =findTweets($user,$keyword);

//画面表示
include_once '../Views/manager_search.php';
