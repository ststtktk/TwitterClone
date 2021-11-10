<!--矢印のように見える「->」は、アロー演算子（オブジェクト演算子）と呼ばれています。
PHPのアロー演算子は、主にクラスから生成されたインスタンスで、
プロパティやメソッドにアクセスする場合に用いられます。

クラスを設計したり、さまざまなオブジェクトを作成・操作したりといったように、
オブジェクト指向なプログラミングをすうえで、アロー演算子はごく基本的な要素です。
-->

<?php

////ユーザーデータを処理

/**
 * ユーザーを作成
 * 
 * @param array $data
 * @return bool
 */
function createUser(array $data)
{
    //DB接続  mysqli関数でデータベースと接続する。$mysqliに接続結果のオブジェクトが入ってくる。
    $mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

    //エラーがある場合　ー>処理停止  接続エラーがあった場合、connect_errno(コネクトエラーナンバー)にint型で数字が入ってくる。
    //$mysqli->connect_error."\n" はエラーメッセージ。
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error . "\n";
        exit;
    }

    //新規登録のSQLクエリを作成。　？はプレースホルダーといって、後で値を設定できる。
    $query = 'INSERT INTO users(email,name,nickname,password) VALUES(?,?,?,?)';

    //プリペアドステートメントに、作成したクエリを登録。
    //プリペアドステートメントは同じステートメントを繰り返し、 高い効率で実行すると同時に、 SQLインジェクションから守ります。
    $statement = $mysqli->prepare($query);

    //パスワードをハッシュ値に変換。password_hash関数はパスワードを暗号のような文字列に変換する。
    $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);

    //クエリのプレースホルダ(?の部分)にカラム値を紐付け。'ssss'がストリングを意味し、最初のsが第二引数部分の$data['email]の型を表す。
    //第一引数は全てsなので、全てストリング型で処理される。
    //bind_param関数は、プリペアドステートメントで使用するSQL文の中で、プレースホルダーに値をバインドするための関数です。
    $statement->bind_param('ssss',$data['email'],$data['name'],$data['nickname'],$data['password']);

    //クエリを実行 
    //executeメソッドでクエリを返す。この関数はtrueかfalseを返す。
    $response = $statement->execute();

    //実行に失敗した場合 ->エラー表示
    if($response===false){
        echo 'エラーメッセージ:' .$mysqli->error ."\n";
    }

    //DB接続を解放
    $statement->close();
    $mysqli->close();

    return $response;

}

/**
 * ユーザーを更新
 * 
 * @param array $data
 * @return bool
 */

 function updateUser(array $data)
 {
     // DB接続
     $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
     if($mysqli->connect_errno){
         echo 'MySQLの接続に失敗しました : ' . $mysqli->connect_error . "\n";
         exit;
     }

     // 更新日時を保存データに追加
     $data['updated_at'] = date('Y-m-d H:i:s');

     // パスワードがある場合->ハッシュタグ値に接続
     if(isset($data['password'])){// データ配列にパスワードがあった場合
         $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
     }

     // ----------
     // SQLクエリを作成(更新)
     // ----------
     // SET句のカラムを準備
     
     $set_columns = [];
        foreach ([ // 更新するカラムをforeachで一つずつ取り出す
            'name', 'nickname', 'email', 'password', 'image_name', 'updated_at'
        ] as $column) {
            // 入力があれば、更新の対象にする
            if (isset($data[$column]) && $data[$column] !== '') {
                $set_columns[] = $column . ' = "' . $mysqli->real_escape_string($data[$column]) . '"';
            }
        }

     // クエリを組み立て
     // UPDATE テーブル名 SET カラム名1でレコードの更新
     $query = 'UPDATE users SET ' . join(',', $set_columns);
     // 更新対象のユーザーidを条件に入れている
     $query .= ' WHERE id = "' . $mysqli->real_escape_string($data['id']) . '"';

     // ----------
     // 戻り値を作成
     // ----------
     // クエリを実行
     $response = $mysqli->query($query);

     // SQLエラーの場合 -> エラー表示
     if($response === false){
         echo 'エラーメッセージ:' .$mysqli->error. "\n";
     }

     // ----------
     // 後処理
     // ----------
     // DB接続を開放
     $mysqli->close();

     return $response;
 }




/**
 * ユーザー情報取得：ログインチェック
 * 
 * @param string $email
 * @param string $password
 * @return array|false
 * 戻り値がarrayかfalseになる
 */
function findUserAndCheakPassword(string $email, string $password)
{
    //DB接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);

    //接続エラーがある場合->処理停止
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_error . "\n";
        exit;
    }

    //入力値のエスケープ。real_escape_string関数でemail関数にsqlが入っていても実行されないようにする
    $email = $mysqli->real_escape_string($email);

    //SQLクエリを作成
    // - 外部からのリクエストは何が入ってくるのかわからないので、必ず、エスケープしたもの(今回だと$email)をクオートで囲む
    //メールアドレスで条件を絞ってセレクトする
    $query = 'SELECT * FROM users WHERE email = "' . $email . '"';

    //クエリ実行
    $result = $mysqli->query($query);

    //クエリ実行に失敗した場合->return
    //queryメソッドの結果がfalseの場合、エラーを表示
    if(!$result){
        //MySQL処理中にエラー発生
        echo 'エラーメッセージ:' . $mysqli->error . "\n";
        $mysqli->close();
        return false;
    }

    //ユーザー情報を取得
    //fetch_arrayメソッドはレコードを一件取得
    $user = $result->fetch_array(MYSQLI_ASSOC);
    //ユーザーが存在しない場合 ->return
    if(!$user){
        $mysqli->close();
        return false;
    }

    //パスワードチェック、不一致の場合->return
    //password_verify関数で入力されたパスワードとデータベースに保存されてあったパスワードの#値を比較して一致するかどうかをチェック
    if(!password_verify($password,$user['password'])){
        $mysqli->close();
        return false;
    }

    //DB接続を解放
    $mysqli->close();

    return $user;
}

/**
 * ユーザーを１件取得
 * 
 * @param int $user_id
 * @param int $login_user_id
 * @return array|false
 */
function findUser(int $user_id,int $login_user_id = null)
{
    //DB接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。: ' . $mysqli->connect_error . "\n";
        exit;
    }

    //引数のエスケープ(SQLインジェクション対策)
    $user_id = $mysqli->real_escape_string($user_id);
    $login_user_id = $mysqli->real_escape_string($login_user_id);

    // ----------
    //SQLクエリを作成(検索)
    // ----------
    //ユーザー情報を取得するクエリ
    $query = <<<SQL
        SELECT 
            -- 「select 列名」SELECT文で指定した列名のデータをFROM句で指定したテーブルから取得
            U.id,
            U.name,
            U.nickname,
            U.email,
            U.image_name,
            -- フォロー中の数(サブクエリの追加)
            -- followsテーブルのレコード数(COUNT()を数える)
            -- SELECT COUNT(*) FROM テーブル名;テーブルの件数を取得する。
            -- WHERE句を使用して条件を指定することで，取得したいデータのみを取得することができます．
            (SELECT COUNT(1) FROM follows WHERE status = 'active' AND follow_user_id = U.id) AS follow_user_count,
            -- フォローワー中の数(サブクエリの追加)
            -- followed_user_id = U.idが表示対象をフォローしているユーザーという意味
            (SELECT COUNT(1) FROM follows WHERE status = 'active' AND followed_user_id = U.id) AS followed_user_count,
            -- ログインユーザーがフォローしている場合、フォローIDが入る
            F.id AS follow_id
        FROM 
            -- usersテーブルの別名をUにする
            users AS U 
            -- followsテーブルを紐づける。ONで結合の条件をつける。表示対象のユーザーを自分がフォローしているという条件。フォローしている場合に限り、セレクトにフォロ-idが入ってくる
            LEFT JOIN 
                follows AS F ON F.status = 'active' AND F.followed_user_id = '$user_id' AND F.follow_user_id = '$login_user_id'
        WHERE 
            -- active(既存会員)かつU.idが表示対象のuser_idで絞る            
            U.status = 'active'AND U.id ='$user_id'
    SQL;


    // ----------
    //戻り値を作成
    // ----------
    // クエリを実行し、SQLエラーでない場合
    if($result = $mysqli->query($query)){//代入された値があれば
        //戻り値の変数にセット：ユーザー情報１件
        $response = $result->fetch_array(MYSQLI_ASSOC);
    }else{
        //戻り値用の変数にセット：失敗
        $response = false;
        echo 'エラーメッセージ:' . $mysqli->error . "\n";
    }

    // ----------
    // 後処理
    // ----------
    // DB開放
    $mysqli -> close();

    return $response;
}