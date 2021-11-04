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
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:' . $mysqli->connect_errno . "\n";
        exit;
    }

    //新規登録のSQLクエリを作成
    //user_id=ユーザーid、body=メッセージ、image_name=画像のファイル名をセット
    $query = 'INSERT INTO tweets (user_id, body, image_name) VALUES(?,?,?)';

    //プリペアドステートメントにクエリを登録
    $statement = $mysqli->prepare($query);

    //プレースホルダーにカラム値を紐付け(i=int,s=string)
    //'iss'の部分は、処理したい型で指定。user_idはint型で処理したいのでi、bodyとimage_nameはstring型で処理したいのでs。
    //bind_param関数は、プリペアドステートメントで使用するSQL文の中で、プレースホルダーに値をバインドするための関数です。
    $statement->bind_param('iss',$data['user_id'],$data['body'],$data['image_name']);//TODO

    //クエリを実行
    //executeメソッドでクエリを返す。この関数はtrueかfalseを返す。
    $response = $statement->execute();
    if($response===false){
        echo 'エラーメッセージ:' .$mysqli->error . "\n";
    }

    //DB接続を解放
    $statement->close();
    $mysqli->close();

    return $response;

}