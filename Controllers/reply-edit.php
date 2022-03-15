<?php
///////////////////////////////////////
// リプライ編集コントローラー
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
    header('HTTP/1.0 404 Not Found');
    exit;
}

// ----------
// 上書きする
// ----------
$id = $_POST['reply_id'];
$body = $_POST['reply_body'];
$edit = '管理者により編集されました。';
$tweetid = $_POST['tweet_id'];

if(editreply($id,$body,$edit)){
    header('Location: '.HOME_URL.'Controllers/manager_reply.php?tweet_id='.$tweetid);
    exit;
}
