<?php
///////////////////////////////////////
// リプライデリートコントローラー
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
// リプライデリートする
// ----------
$id = $_POST['reply_id'];
$body = 'リプライがありません';
$replydelete = '管理者により削除されました。';
$tweetid = $_POST['tweet_id'];

if(deletereply($id,$body,$replydelete)){
    header('Location: '.HOME_URL.'Controllers/manager_reply.php?tweet_id='.$tweetid);
    exit;
}
