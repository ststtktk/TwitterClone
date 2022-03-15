<?php
//////////
//管理者用プロフィールコントローラー
//////////

//設定を読み込み
include_once '../config.php';
include_once '../util.php';
include_once '../Models/users.php';
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
//ユーザー情報を変更
// ----------
// ニックネームとユーザー名とメールアドレスが入力されている場合
if (isset($_POST['nickname']) && isset($_POST['name']) && isset($_POST['email'])) {
    $data = [
        'id' => $user['id'],
        'name' => $_POST['name'],
        'nickname' => $_POST['nickname'],
        'email' => $_POST['email'],
    ];
    // パスワードが入力されていた場合。ポストにパスワード要素が存在していて、カラで出なければパスワードの変更を行います
    if (isset($_POST['password']) && $_POST['password'] !== '') {
        $data['password'] = $_POST['password'];
    }
    if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        $data['image_name'] = uploadImage($user, $_FILES['image'], 'user');
    }
    if (updateUser($data)) {
        $user = findUser($user['id']);
        // saveUserSessionで保存
        saveUserSession($user);
 
        header('Location: ' . HOME_URL . 'Controllers/profile.php');
        exit;
    }
}

// ----------
// 表示するユーザーIDを取得(デフォルトはログインユーザー)
// ----------
// URLにuser_idがある場合->それを対象ユーザーにする。初期値は自分のuser_idを入れておく
$requested_user_id=$user['id'];
if (isset($_GET['user_id'])){
    $requested_user_id = $_GET['user_id'];
}

// ----------
// 表示用の変数
// ----------
// ユーザー情報
$view_user = $user;
$view_requested_user = findUser($requested_user_id,$user['id']);
$view_tweets = findTweets($user,null,[$requested_user_id]);

include_once '../Views/manager_profile.php';