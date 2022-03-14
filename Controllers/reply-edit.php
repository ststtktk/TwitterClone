<?php
///////////////////////////////////////
// デリートコントローラー
///////////////////////////////////////


// 設定を読み込み
include_once '../config.php';
// 便利な関数を読み込み
include_once '../util.php';
// いいね！データ操作モデルを読み込む
include_once '../Models/likes.php';
// 通知データ操作モデルを読み込む
include_once '../Models/notifications.php';
//ユーザーデータ操作モデルを読み込む
include_once '../Models/users.php';
// ツイートデータ操作モデルを読み込む
include_once '../Models/tweets.php';
// ツイートデリートの削除モデルを読み込む
include_once '../Models/delete.php';

// ------------------------------------
// ログインチェック
// ------------------------------------
$user = getUserSession();
// ログインしていない場合
// ログインチェックの判断方法はuser情報がsessionの中にあるか
if (!$user) {
    // 404エラー
    header('HTTP/1.0 404 Not Found');
    exit;
}

// ----------
// 上書きする
// ----------
$id = $_POST['reply_id'];
$body = $_POST['reply_body'];
$tweetid = $_POST['tweet_id'];

if(editreply($id,$body)){
    //ホーム画面に遷移
    header('Location: '.HOME_URL.'Controllers/manager_reply.php?tweet_id='.$tweetid);
    exit;
}
