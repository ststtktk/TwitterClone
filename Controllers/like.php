<?php
///////////////////////////////////////
// ライクコントローラー
///////////////////////////////////////
 
// 設定を読み込み
include_once '../config.php';
// 便利な関数を読み込み
include_once '../util.php';
// いいね！データ操作モデルを読み込む
include_once '../Models/likes.php';
 
// ------------------------------------
// ログインチェック
// ------------------------------------
$user = getUserSession();
// ログインしていない場合
// ログインチェックの判断方法はuser情報がsessionの中にあるか
if (!$user) {
    // 404エラー
    header('HTTP/1.0 404 Not Found');
    exit;
}
// ----------
// いいね！する
// ----------
$like_id = null;
// tweet_idがpostされた場合
// いいね！する場合はtweet_id、取り消しの場合はlike_id
if(isset($_POST['tweet_id'])){
    $data = [//いいね登録する直前に登録する内容をデータ変数にまとめる
        'tweet_id' => $_POST['tweet_id'],
        'user_id' => $user['id'],//ログインしているユーザー
    ];
    // いいね！登録
    $like_id = createLike($data);
}
// ----------
// いいね！取り消し
// ----------
// like_idがPOSTされた場合
if(isset($_POST['like_id'])){
    $data = [
        'like_id' => $_POST['like_id'],
        'user_id' => $user['id'],
    ];
    // いいね！削除
    deleteLike($data);
}

// ----------
// JSON形式で結果を返却(JSONとは、javascript object notationの略)
// ----------

$response = [// 返却したいデータを配列で表す
    'message' => 'successful',
    // いいね！した時のみに値を入る
    'like_id' => $like_id,
];
// headerのContent-Typeで返却したコンテンツがどういった形式で作られているかということをブラウザに伝える
// 今回の場合は、json形式
header('Content-Type: application/json; charset=utf-8');
echo json_encode($response);// 配列のデータをjson形式にして出力
