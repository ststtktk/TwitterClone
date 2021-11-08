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
 * ツイート一覧取得
 * 
 * @param array $user ログインしているユーザー情報
 * @param string $keyword 検索キーワード
 * @return array|false 戻り値はarrayかfalse
 */

function findTweets(array $user,$keyword = null)//キーワード検索をしない場合もあるため、nullを設定  
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
        //query関数に追記する感じで記入
        //$queryのCONCAT関数は、複数の文字またはカラムを連結することができる
        $query .= ' AND CONCAT(U.nickname, U.name, T.body) LIKE "%' . $keyword . '%"';
    }
 
    // 新しい順に並び替え
    $query .= ' ORDER BY T.created_at DESC';
    // 表示件数50件
    $query .= ' LIMIT 50';

    //クエリ実行
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

