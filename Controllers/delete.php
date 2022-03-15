<?php
///////////////////////////////////////
// デリートコントローラー
///////////////////////////////////////

// 設定を読み込み
include_once '../config.php';
include_once '../util.php';
include_once '../Models/delete.php';

// ------------------------------------
// ログインチェック
// ------------------------------------
$user = getUserSession();
if (!$user) {
    header('HTTP/1.0 404 Not Found');
    exit;
}
// ----------
// デリートする
// ----------
$id = $_POST['tweet_id'];
$body = 'ツイートがありません';
$tweetdelete = '管理者により削除されました。';
if(deletetweet($id,$body,$tweetdelete)){
    header('Location: '.HOME_URL.'Controllers/manager_search.php');
    exit;
}
