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
// デリートする
// ----------
$id = $_POST['tweet_id'];
deletetweet($id);

// 検索キーワードを取得
$keyword = null;
if(isset($_GET['keyword'])){
    $keyword = $_GET['keyword'];
}

//表示用の変数
$view_user = $user;
$view_keyword = $keyword;
//ツイート一覧。 モデルから取得
$view_tweets = findTweets($user,$keyword);

include_once '../Views/manager_search.php';
