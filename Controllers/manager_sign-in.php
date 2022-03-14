<?php
////サインコントローラー////

//設定を読み込み
include_once '../config.php';
//便利な関数を読み込み
include_once '../util.php';
//ユーザーデータ操作モデルを読み込み
include_once '../Models/users.php';

//ログイン結果
$try_login_result = null;

//メールアドレスとパスワードが入力されている場合
if(isset($_POST['email']) && isset($_POST['password'])) {
    //ログインチェック実行
    $user = findManagerAndCheakPassword($_POST['email'],$_POST['password']);

    //ログインに成功した場合
    if($user){
        //ユーザー情報をセッションに保存
        saveUserSession($user);

        //ホーム画面に移動
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