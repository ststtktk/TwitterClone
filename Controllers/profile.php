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
        // 先ほどの配列で用意してあるデータ配列にパスワードの要素を追加している形になる
        $data['password'] = $_POST['password'];
    }
 
    /*ファイルがアップロードされていた場合->画像アップロード。
      is_uploaded_file関数でアップロードされたファイルがPOST通信で送信されてきたものかを確認することができる。tmp_nameは一時的な名前
      uploaiImage関数でサーバーに画像を保存 */
    if (isset($_FILES['image']) && is_uploaded_file($_FILES['image']['tmp_name'])) {
        $data['image_name'] = uploadImage($user, $_FILES['image'], 'user');
    }
 
    // 更新を実行し、成功した場合
    if (updateUser($data)) {
        /* 更新後のユーザー情報をセッションに保存し直す
           findUser関数で自分の情報をDBから取得 */
        $user = findUser($user['id']);
        // saveUserSessionで保存
        saveUserSession($user);
 
        // リロード
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
// プロフィール詳細を取得。$requested_user_idが表示するユーザーのid。
// 第二引数には自分のid。これは、表示対象のユーザーを自分がフォローしているかどうかを判断するためにセット。
$view_requested_user = findUser($requested_user_id,$user['id']);
// ツイート一覧
$view_tweets = findTweets($user,null,[$requested_user_id]);


// 画面表示
include_once '../Views/profile.php';