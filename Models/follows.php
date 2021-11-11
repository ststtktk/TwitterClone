<?php

// ----------
// フォローデータを処理
// ----------

/**
 *  フォローを作成
 * 
 * @param array $data
 * @return int|false
 */
// 引数が配列
function createFollow(array $data)
{
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    // 接続チェック
    if ($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error . "\n";
        exit;
    }

    // ----------
    // SQLクエリを作成(新規登録)
    // ----------
    // INSERT INTO テーブル名 (カラム1, カラム2, …) VALUES (値1, 値2) :レコードの挿入
    $query = 'INSERT INTO follows (follow_user_id, followed_user_id) VALUES (?,?)';
    $statement = $mysqli->prepare($query);

    // プレースホルダに値をセット
    $statement->bind_param('ii',$data['follow_user_id'],$data['followed_user_id']);

    // ---------
    // 戻り値を作成
    // ---------
    // クエリを実行し、SQLエラーでない場合。$statementのクエリをexecuteメソッドで実行
    if ($statement->execute()){
        // 戻り値用の変数にセット : インサートID(follows.id)つまり、新規登録されたレコードのidを戻り値用の変数にセット
        $response = $mysqli->insert_id;
    } else {
        // 戻り値用の変数にセット : 失敗
        $response = false;
        echo 'エラーメッセージ:' . $mysqli->error."\n";
    }

    // ----------
    // 後処理
    // ----------
    // DB接続を開放
    $statement->close();
    $mysqli->close();

    return $response;
}


/**
 *  フォロー取り消し
 * 
 * @param array $data
 * @return bool
 */

function deleteFollow(array $data)
{
    // DB接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if ($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error . "\n";
        exit;
    }

    // 更新日時
    $data['updated_at'] = date('Y-m-d H:i:s');

    // ----------
    // SQLクエリを作成
    // ----------
    // 論理削除(statusでdeleteを指定して、外からは削除したように見える)のクエリを作成。
    // UPDATE テーブル名 SET カラム名1 = "値1", カラム名2 = "値2", ...;
    // UPDATE：レコードの更新 WHEREで検索条件を指定
    // idだけでも絞れるが、follow_user_idを加えることで、他人のフォローを削除できなくする
    $query = 'UPDATE follows SET status = "deleted", updated_at = ? WHERE id = ? AND follow_user_id = ?';
    $statement = $mysqli->prepare($query);
    
    // プレースホルダに値をセット
    $statement->bind_param('sii',$data['updated_at'],$data['follow_id'],$data['follow_user_id']);

    // ----------
    // 戻り値を作成
    // ----------
    $response = $statement->execute();

    //SQLエラーの場合->エラー表示
    if ($response === false){
        echo 'エラーメッセージ:' . $mysqli->error . "\n";
    }

    // ----------
    // 後処理
    // ----------
    // DB接続を開放
    $statement->close();
    $mysqli->close();

    return $response;
}

/**
 *  自分がフォローしているユーザーID一覧を取得
 * 
 * @param int $follow_user_id
 * @return array|false
 *  
 */
// 引数は自分のユーザーID
function findfollowingUserIds(int $follow_user_id)
{
    // DB接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if ($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error . "\n";
        exit;
    }

    // エスケープ
    $follow_user_id = $mysqli->real_escape_string($follow_user_id);

    // ----------
    // SQLクエリを作成
    // ----------
    // 自分のフォローデータを取得
    $query = 'SELECT followed_user_id FROM follows'
         . ' WHERE status = "active" AND follow_user_id ="' . $follow_user_id . '"';

    // ----------
    // 戻り値を作成
    // ----------
    $result = $mysqli->query($query);

    // SQLエラーの場合->エラー表示
    if (!$result){
        echo 'エラーメッセージ:' . $mysqli->error . "\n";
        // DB接続を開放
        $mysqli->close();
        return false;
    }

    // フォロー一覧を取得 fetch_allメソッドでヒットした全てのメソッドを取得
    $follows = $result->fetch_all(MYSQLI_ASSOC);

    // ユーザーIDの一覧を作成
    // DBから取得したレコード一覧をループして、user_idのみが入る一次元の配列を作成
    $following_user_ids = [];
    foreach ($follows as $follow){
        $following_user_ids[] = $follow['followed_user_id'];
    }

    // ----------
    // 後処理
    // ----------
    // DB接続を開放
    $mysqli->close();

    // user_id一覧を返却
    return $following_user_ids;
}
