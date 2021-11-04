<?php
////ホームコントローラー////

//設定を読み込み
include_once '../config.php';
//便利な関数を読み込み
include_once '../util.php';

//ツイートデータ操作モデルを読み込む
include_once '../Models/tweets.php';


//ログインしているか
$user = getUserSession();
if(!$user){//変数userに値がなければログインしていない事になる
    //ログインしていない
    //header関数はブラウザに命令ができる。Locationという命令は、下記にかいたURLに遷移させるという内容
    header('Location:' . HOME_URL . 'Controllers/sign-in.php');
    exit;
}

//表示用の変数
$view_user = $user;
//ツイート一覧。 モデルから取得
$view_tweets =findTweets($user);

//画面表示
include_once '../Views/home.php';
