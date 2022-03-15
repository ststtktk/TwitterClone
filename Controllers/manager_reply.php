<?php
//////////
//管理者用リプライコントローラー
//////////

//設定を読み込み
include_once '../config.php';
include_once '../util.php';
include_once '../Models/tweets.php';

// ----------
//ログインチェック
// ----------
$user = getUserSession();
if(!$user){
    //ログインしていない
    header('Location:' .HOME_URL . 'Controllers/sign-in.php');
    exit;
}

// ---------
// 選択したツイートを取得
// ---------
// 検索キーワードを取得
if(isset($_GET['tweet_id'])){
    $reply = $_GET['tweet_id'];
}
//ツイート一覧。 モデルから取得
$view_tweets =replyTweet($reply);

// ----------
// リプライツイートを取得
// ----------
if (isset($_GET['tweet_id'])){
    $requested_tweet_id = $_GET['tweet_id'];
};
 //リプライツイート情報
 $reply_tweet = reply($requested_tweet_id);

include_once '../Views/manager_reply.php';
