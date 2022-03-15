<?php
///////////////////////////////////////
// ツイート編集コントローラー
///////////////////////////////////////

// 設定を読み込み
include_once '../config.php';
include_once '../util.php';
include_once '../Models/tweets.php';

// ------------------------------------
// ログインチェック
// ------------------------------------
$user = getUserSession();
if (!$user) {
    // 404エラー
    header('HTTP/1.0 404 Not Found');
    exit;
}

// ----------
// 上書きする
// ----------
$id = $_POST['tweet_id'];
$body = $_POST['tweet_body'];
$edit = '管理者により編集されました。';
if(edittweet($id,$body,$edit)){
    header('Location: '.HOME_URL.'Controllers/manager_search.php');
    exit;
}

