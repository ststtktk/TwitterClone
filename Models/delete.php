<?php
/////
//デリート
/////

/**
 * デリート機能
 * 
 * @param array $data
 */

 function deletetweet($id,$body,$tweetdelete)
 {
    $tweet_id = (int) htmlspecialchars($id,ENT_QUOTES);
     
     //DB接続
     $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
     if($mysqli->connect_errno){
         echo 'MySQLの接続に失敗しました:'.$mysqli->connect_error."\n";
     }
     //SQLクエリを作成
     //$query = "DELETE FROM tweets WHERE id = $tweet_id"; 
     $query = 'UPDATE tweets SET body = ? , edit = ? WHERE id = ? ';
     $statement = $mysqli->prepare($query);
     $statement->bind_param('ssi',$body,$tweetdelete,$tweet_id);

     // 戻り値を作成
     $response = $statement->execute();

     //SQLエラーの場合->エラーを表示
     if($response===false){
         echo 'エラーメッセージ:' .$mysqli->error . "\n";
     }

     // DB接続を解放
     $statement->close();
     $mysqli->close();

     return $response;
 }

 /**
 * リプライデリート機能
 * 
 * @param array $id
 */

function deletereply($id,$body,$replydelete)
{
   $reply_id = (int) htmlspecialchars($id,ENT_QUOTES);
    
    //DB接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました:'.$mysqli->connect_error."\n";
    }
    //SQLクエリを作成
    $query = 'UPDATE replys SET reply_body = ? , edit = ? WHERE id = ? ';
    $statement = $mysqli->prepare($query);
    $statement->bind_param('ssi',$body,$replydelete,$reply_id);

    // 戻り値を作成
    $response = $statement->execute();

    //SQLエラーの場合->エラーを表示
    if($response===false){
        echo 'エラーメッセージ:' .$mysqli->error . "\n";
    }

    // DB接続を解放
    $statement->close();
    $mysqli->close();

    return $response;
}