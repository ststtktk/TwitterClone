<?php
////管理者用サインコントローラー////

include_once '../config.php';
include_once '../util.php';
include_once '../Models/users.php';

//ログイン結果
$try_login_result = null;

//メールアドレスとパスワードが入力されている場合
if(isset($_POST['email']) && isset($_POST['password'])) {
    $user = findManagerAndCheakPassword($_POST['email'],$_POST['password']);

    //ログインに成功した場合
    if($user){
        //ユーザー情報をセッションに保存
        saveUserSession($user);
        header('Location:' . HOME_URL . 'Controllers/manager_home.php');
        exit;
    }else{
        //ログイン結果を失敗にする
        $try_login_result=false;
    }
}
//表示用の変数
$view_try_login_result = $try_login_result;

//画面表示
include_once '../Views/manager_sign-in.php';