<?php
////ホームコントローラー////

//設定を読み込み
include_once '../config.php';
//便利な関数を読み込み
include_once '../util.php';

//ツイートデータ操作モデルを読み込む
include_once '../Models/tweets.php';
// フォローデータ操作モデルを読み込む
include_once '../Models/follows.php';


//ログインしているか
$user = getUserSession();
if(!$user){//変数userに値がなければログインしていない事になる
    //ログインしてない
    //header関数はブラウザに命令ができる。Locationという命令は、下記にかいたURLに遷移させるという内容
    header('Location:' . HOME_URL . 'Controllers/sign-in.php');
    exit;
}

// 自分がフォローしているユーザーID一覧を取得。$userはログインしているユーザーのこと
$following_user_ids = findFollowingUserIds($user['id']);
// 自分のツイートも表示するために自分のIDも追加
$following_user_ids[] = $user['id'];

//表示用の変数
$view_user = $user;
//ツイート一覧。 モデルから取得
$view_tweets =findTweets($user, null, $following_user_ids);

//画面表示
include_once '../Views/home.php';
