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
// 通知データ操作モデルを読み込む
include_once '../Models/notifications.php';
// ツイートデータ操作モデルを読み込む
include_once '../Models/tweets.php';


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
if (isset($_POST['tweet_id'])){
    $data = [ // いいね登録する直前に登録する内容をデータ変数にまとめる
        'tweet_id' => $_POST['tweet_id'],
        'user_id' => $user['id'], //ログインしているユーザー
    ];
    // いいね！登録
    $like_id = createLike($data);

    // ツイートを取得 findTweet関数はtweet_idからツイートの詳細を取得する関数。その詳細の中にuser_idが含まれている
    $tweet = findTweet($_POST['tweet_id']);
    if ($tweet){
    // 通知を登録
    // received_user_idにセットするuser_idがないため、tweet_idからツイート主のuser_idを取得する必要がある
    $data_notification = [
        'received_user_id' => $tweet['user_id'],
        'sent_user_id' => $user['id'],
        'message' => 'いいね！されました。',
    ];
    createNotification($data_notification);
    }
}

// ----------
// いいね！取り消し
// ----------
// like_idがPOSTされた場合
if (isset($_POST['like_id'])){
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
