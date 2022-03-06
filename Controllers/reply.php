<?php
//////////
//プロフィールコントローラー
//////////

//設定を読み込み
include_once '../config.php';
include_once '../util.php';

//ユーザーデータ操作モデルを読み込む
include_once '../Models/users.php';
//ツイートデータ操作モデルを読み込む
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


// ----------
// 表示するユーザーIDを取得(デフォルトはログインユーザー)
// ----------
// URLにuser_idがある場合->それを対象ユーザーにする。初期値は自分のuser_idを入れておく
//$requested_user_id=$user['id'];
//if (isset($_GET['user_id'])){
//    $requested_user_id = $_GET['user_id'];
//}


// ----------
// 表示用の変数
// ----------
// ユーザー情報
//$view_user = $user;
// プロフィール詳細を取得。$requested_user_idが表示するユーザーのid。
// 第二引数には自分のid。これは、表示対象のユーザーを自分がフォローしているかどうかを判断するためにセット。
//$view_requested_user = findUser($requested_user_id,$user['id']);
// ツイート一覧
//$view_tweets = findTweets($user,null,[$requested_user_id]);

// ----------
// 表示するツイートIDを取得
// ----------
// $requested_tweet_id=$tweet['id'];
// if (isset($_GET['tweet_id'])){
//     $requested_tweet_id = $_GET['tweet_id'];
// }

// $replyid = $_GET['tweet_id'];

// //ツイート情報
// $view_tweet = $tweet;
// $reply_tweet = replyTweets($requested_tweet_id);



// ---------
// 選択したツイートを取得
// ---------
// 検索キーワードを取得
if(isset($_GET['tweet_id'])){
    $reply = $_GET['tweet_id'];
}

//表示用の変数
$view_user = $user;
$view_keyword = $reply;
//ツイート一覧。 モデルから取得
$view_tweets =replyTweet($user,$reply);



// ----------
// リプライツイートを取得
// ----------
$requested_tweet_id=$tweet['id'];
if (isset($_GET['tweet_id'])){
    $requested_tweet_id = $_GET['tweet_id'];
}

 $replyid = $_GET['tweet_id'];

 //ツイート情報
 $view_tweet = $tweet;
 $reply_tweet = Tweetreply($requested_tweet_id);




// 画面表示
include_once '../Views/reply.php';
