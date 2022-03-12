<?php
/////
// ツイートデータを処理
////

/**
 * ツイート作成
 * 
 * @param array $data
 * @return bool
 */

 //データベースに登録したい値をセット。今回でいうと$data。
function createTweet(array $data)
{
    //DB接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    
    //接続エラーがある場合->処理停止
    // インスタンスのプロパティやメソッドにアクセスするには、アロー演算子と呼ばれれる -> を使います。
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error . "\n";
        exit;
    }

    //新規登録のSQLクエリを作成
    //user_id=ユーザーid、body=メッセージ、image_name=画像のファイル名をセット
    $query = 'INSERT INTO tweets(user_id,body,image_name) VALUES(?,?,?)';

    //プリペアドステートメントにクエリを登録。(prepareでクエリの実行準備)
    $statement = $mysqli->prepare($query);

    //プレースホルダーにカラム値を紐付け(i=int,s=string)
    //'iss'の部分は、処理したい型で指定。user_idはint型で処理したいのでi、bodyとimage_nameはstring型で処理したいのでs。
    //bind_param関数は、プリペアドステートメントで使用するSQL文の中で、プレースホルダーに値をバインドするための関数です。
    $statement->bind_param('iss',$data['user_id'],$data['body'],$data['image_name']);

    //クエリを実行
    //executeメソッドでクエリを返す。この関数はtrueかfalseを返す。
    $response = $statement->execute();
    if($response===false){
        echo 'エラーメッセージ:'.$mysqli->error."\n";
    }

    //接続を閉じる
    $statement->close();
    $mysqli->close();

    return $response;

}

/**
 *  ツイート１件取得
 * 
 * @param int $tweet_id
 * @return array|false
 */
function findTweet(int $tweet_id)
{
    //DB接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error ."\n";
        exit;
    }

    // エスケープ
    $tweet_id = $mysqli->real_escape_string($tweet_id);

    // ----------
    // SQLクエリを作成
    // ----------
    $query = 'SELECT * FROM tweets WHERE status = "active" AND id = "' . $tweet_id . '"';

    // ----------
    // 戻り値を作成
    // ----------
    if ($result = $mysqli->query($query)){ 
        // データ１件取得
        $response = $result->fetch_array(MYSQLI_ASSOC);
    } else {
        $response = false;
        echo 'エラーメッセージ:' . $mysqli->error . "\n";
    }

    // ----------
    // 後処理
    // ---------
    // DB開放
    $mysqli->close();

    return $response;

}


/**
 * ツイート一覧取得
 * 引数設定
 * @param array $user ログインしているユーザー情報
 * @param string $keyword 検索キーワード
 * @param array $user_ids ユーザーID一覧
 * @return array|false 戻り値はarrayかfalse
 */

function findTweets(array $user,$keyword = null,array $user_ids = null )//キーワード検索をしない場合もあるため、nullを設定  
{   
    //DB接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    //接続エラーがある場合->処理停止
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error ."\n";
        exit;
    }

    //ログインユーザーIDをエスケープ
    $login_user_id = $mysqli->real_escape_string($user['id']);

    //検索のSQLクエリを作成。SQLが長いため、ヒアドキュメントで記述
    $query = <<<SQL
        SELECT 
            -- カラム名(例:T.id)に別名(例:tweet_id)を当てる
            T.id AS tweet_id,
            T.status AS tweet_status,
            T.body AS tweet_body,
            T.image_name AS tweet_image_name,
            T.created_at AS tweet_created_at,
            -- ツイートテーブルと紐づくユーザーの情報をセレクトに列挙する
            U.id AS user_id,
            U.name AS user_name,
            U.nickname AS user_nickname,
            U.image_name AS user_image_name,
            -- ログインユーザーがいいね！したか（している場合、値が入る）
            L.id AS like_id,
            -- いいね！数。サブクエリを記入
            -- ステータスがアクティブかつ外側で取得したtweet_idで絞り込む。この一連に式にも名前がつけられる
            -- 外側に紐づく値がある、サブクエリを相関サブクエリと言って、外側で取得したレコードの数だけサブクエリが実行されるので、処理が遅くなる可能性がある
            (SELECT COUNT(*) FROM likes WHERE status = 'active' AND tweet_id = T.id) AS like_count
        FROM
            -- カラム名やテーブル名の後にASをつけて、その後に名前を指定すると別名をつけることができる。
            -- この場合、tweetとtは同じものをさす
            tweets AS T
            -- ユーザーテーブルをusers.idとtweets.user_idで紐付ける
            JOIN
            -- U.id(user_id)とT.user_id(tweet.user_id)で紐付けて、かつ、ユーザーテーブルがactiveの場合
            -- activeは有効の意味
            users AS U ON U.id = T.user_id AND U.status = 'active'
            -- いいね！テーブルをlikes.tweet_idとtweets_id紐づける
            LEFT JOIN
            -- like stableのステータスが有効な物に絞り、さらにlike stableのuser_idがログイン中のユーザーid($login_user_id)の物だけに絞り込む
            -- 呟きに対して、自分がいいねしているかどうかの判断材料として使用
            likes AS L ON L.tweet_id = T.id AND L.status = 'active' AND L.user_id = '$login_user_id'
        WHERE
            -- このt.statusはtweetテーブルにtという別名を当てているので、tweetテーブルのステータスとなる
            T.status = 'active'
    SQL;

    // 検索キーワードが入力されていた場合
    if (isset($keyword)) {
        // エスケープ
        $keyword = $mysqli->real_escape_string($keyword);
        // ツイート主のニックネーム・ユーザー名・本文から部分一致検索
        //query変数に追記する感じで記入
        //$queryのCONCAT関数は、複数の文字またはカラムを連結することができる
        $query .= ' AND CONCAT(U.nickname, U.name, T.body) LIKE "%' . $keyword . '%"';
    }

    // ユーザーIDが指定されている場合
    // $user_idsは、複数のユーザーidが配列で入っているからforeachを使い、一つずつ取り出す
    if (isset($user_ids)) {
        foreach ($user_ids as $key => $user_id) {
            $user_ids[$key] = $mysqli->real_escape_string($user_id);
        }
        // エスケープ済みのuser_id変数をダブルコーテーションを含むカンマ区切りで連結させて一つの文字列にする
        // joinメソッドとは、指定された配列内の要素を文字列として連結するためのメソッド
        $user_ids_csv = '"' . join('","', $user_ids) . '"';
        // INでユーザーID一覧に含まれるユーザーで絞る
        $query .= ' AND T.user_id IN (' . $user_ids_csv . ')';
    }
 
    // 新しい順に並び替え
    $query .= ' ORDER BY T.created_at DESC';
    // 表示件数50件
    $query .= ' LIMIT 50';

    // クエリ実行
    $result = $mysqli->query($query);
    if($result){
        //データを配列で受け取る
        //fetch_allメソッドは全てのレコードを取得するメソッド
        $response = $result->fetch_all(MYSQLI_ASSOC);
    }else{
        $response = false;
        echo'エラーメッセージ:'.$mysqli->error ."\n";
    }

    $mysqli->close();

    return $response;
}


 /**
  * リプライするツイートの取得
  * 
  */
function replyTweet( )  
{   
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error ."\n";
        exit;
    }

    $login_user_id = $mysqli->real_escape_string($user['id']);
    $tweet_id = $_GET['tweet_id'];

    $query = <<<SQL
        SELECT 
            T.id AS tweet_id,
            T.status AS tweet_status,
            T.body AS tweet_body,
            T.image_name AS tweet_image_name,
            T.created_at AS tweet_created_at,
            U.id AS user_id,
            U.name AS user_name,
            U.nickname AS user_nickname,
            U.image_name AS user_image_name,
            L.id AS like_id,
            (SELECT COUNT(*) FROM likes WHERE status = 'active' AND tweet_id = T.id) AS like_count
        FROM
            tweets AS T
            JOIN
            users AS U ON U.id = T.user_id AND U.status = 'active'
            LEFT JOIN
            likes AS L ON L.tweet_id = T.id AND L.status = 'active' AND L.user_id = '$login_user_id'
        WHERE
            T.status = 'active' AND T.id = $tweet_id
    SQL;

    if (isset($reply)) {
        $reply = $mysqli->real_escape_string($reply);
        $query .= ' AND CONCAT(U.nickname, U.name, T.body) LIKE "%' . $reply . '%"';
    }

    if (isset($user_ids)) {
        foreach ($user_ids as $key => $user_id) {
            $user_ids[$key] = $mysqli->real_escape_string($user_id);
        }
        $user_ids_csv = '"' . join('","', $user_ids) . '"';
        $query .= ' AND T.user_id IN (' . $user_ids_csv . ')';
    }
    $query .= ' ORDER BY T.created_at DESC';
    $query .= ' LIMIT 50';

    $result = $mysqli->query($query);
    if($result){
        $response = $result->fetch_all(MYSQLI_ASSOC);
    }else{
        $response = false;
        echo'エラーメッセージ:'.$mysqli->error ."\n";
    }
    $mysqli->close();

    return $response;
};


/**
 * リプライ作成
 * 
 */

 function createReply(array $data)
 {
     $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
     if($mysqli->connect_errno){
         echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error . "\n";
         exit;
     }
 
     $query = 'INSERT INTO replys(user_id,tweet_id,reply_body) VALUES(?,?,?)';
     $statement = $mysqli->prepare($query);
     $statement->bind_param('iis',$data['user_id'],$data['tweet_id'],$data['reply_body']);
 
     $response = $statement->execute();
     if($response===false){
         echo 'エラーメッセージ:'.$mysqli->error."\n";
     }
 
     $statement->close();
     $mysqli->close();
 
     return $response;
 
 }

/**
 * リプライツイート
 */
function reply(){

    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error ."\n";
        exit;
    }
    $login_user_id = $mysqli->real_escape_string($user['id']);
    $tweet_id = $_GET['tweet_id'];

    //replysデーブルのtweet_idとtweetsテーブルのidの一致とreplysテーブルのuser_idとusersテーブルのidが一致しているデータのみ統合
    $query = 'SELECT replys.id,replys.user_id,replys.tweet_id,replys.reply_body,users.nickname,users.image_name,replys.created_at
              FROM replys 
                JOIN tweets ON replys.tweet_id = tweets.id
                LEFT JOIN users ON users.id = replys.user_id
              WHERE tweets.id = ' . $tweet_id;
    $query .= ' ORDER BY replys.created_at DESC';

    // ----------
    // 戻り値を作成
    // ----------
    if ($result = $mysqli->query($query)){ 
        $response = $result->fetch_all(MYSQLI_ASSOC);
    } else {
        $response = false;
        echo 'エラーメッセージ:' . $mysqli->error . "\n";
    }

    // ----------
    // 後処理
    // ---------
    $mysqli->close();

    return $response;

}