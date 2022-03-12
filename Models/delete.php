<?php
/////
//デリート
/////

/**
 * デリート機能
 * 
 * @param array $data
 */

 function deletetweet($data)
 {
    $message_id = (int) htmlspecialchars($data,ENT_QUOTES);
     
     //DB接続
     $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
     if($mysqli->connect_errno){
         echo 'MySQLの接続に失敗しました:'.$mysqli->connect_error."\n";
     }
     //SQLクエリを作成
     $query = "DELETE FROM tweets WHERE id = $message_id"; 
     $statement = $mysqli->prepare($query);
     $statement->bind_param('i',$data);

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
 * @param array $data
 */

function deletereply($data)
{
   $message_id = (int) htmlspecialchars($data,ENT_QUOTES);
    
    //DB接続
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました:'.$mysqli->connect_error."\n";
    }
    //SQLクエリを作成
    $query = "DELETE FROM replys WHERE id = $message_id"; 
    $statement = $mysqli->prepare($query);
    $statement->bind_param('i',$data);

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