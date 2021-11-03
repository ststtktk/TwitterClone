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
    //DB接続  mysqli関数でデータベストを接続する。$mysqliに接続結果のオブジェクトが入ってくる。
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