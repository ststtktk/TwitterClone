<?php

////ユーザーデーを処理

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