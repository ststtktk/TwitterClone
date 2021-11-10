<?php 

// ----------
// フォローコントローラー
// ---------


//設定を読み込み
include_once '../config.php';
//便利な関数を読み込み
include_once '../util.php';
//フォローデータ操作モデルを読み込み
include_once '../Models/follows.php';

// ----------
// ログインチェック
// ----------
$user = getUserSession();
// ログインしていない場合
if (!$user){
    // 404エラー
    header('HTTP/1.0 404 Not Found');
    exit;
}

// ----------
// フォローする
// ----------
$follow_id = null;
// followed_user_id がPOSTされた場合
if (isset($_POST['followed_user_id'])){
    $data = [
        'followed_user_id' => $_POST['followed_user_id'], // フォローしたいユーザーのid
        'follow_user_id' => $user['id'], // 自分のid
    ];
    // フォロー登録 作成した新しいレコードのidがここに帰る
    $follow_id = createFollow($data);
} 

// ----------
// フォロー削除
// ----------
//follow_idがPOSTされた場合
if (isset($_POST['follow_id'])){
    $data = [
        'follow_id' => $_POST['follow_id'],
        'follow_user_id' => $user['id'],
    ];
    //フォロー削除
    deleteFollow($data);
}

// ----------
// JSON形式で結果を返却
// ----------
// 返却したいデータを配列でまとめる
$response = [
    'messaga' => 'succesful',
    // フォローした時に入る。follow_idが存在していない場合エラーが表示されるので、//フォローする//の下部分で'null(初期化)'を設定する
    'follow_id' => $follow_id,
];
// headerのContent-Typeで返却したコンテンツがどういった形式で作られているかということをブラウザに伝える
header('Content-Type: application/json; charset=utf-8');
// 作成した配列($response)をjson形式に変換した出力
echo json_encode($response);