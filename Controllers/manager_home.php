<?php
////管理者用ホームコントローラー////
//設定を読み込み
include_once '../config.php';
include_once '../util.php';
include_once '../Models/tweets.php';
include_once '../Models/follows.php';

//ログインしているか
$user = getUserSession();
if(!$user){
    header('Location:' . HOME_URL . 'Controllers/sign-in.php');
    exit;
}

// 自分がフォローしているユーザーID一覧を取得。
$following_user_ids = findFollowingUserIds($user['id']);
// 自分のツイートも表示するために自分のIDも追加
$following_user_ids[] = $user['id'];
$view_user = $user;
$view_tweets =findTweets($user, null, $following_user_ids);

//画面表示
include_once '../Views/manager_home.php';
