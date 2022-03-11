<?php
/////
//デリート
/////

/**
 * デリート機能
 * 
 * @param array $data
 * @return bool
 */

 function deletetweet(Request $request)
 {
     //DB接続
     $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
     if($mysqli->connect_errno){
         echo 'MySQLの接続に失敗しました:'.$mysqli->connect_error."\n";
     }

     // ----------
     //SQLクエリを作成
     // ----------
     // 論理削除のクエリを作成。論理削除はデータそのものを消すのではなく、status=deletedのようにして見えないようにするもの
     $query = 'DELETE FROM tweets WHERE id = :id';
     // $mysqli(DB)にアクセスして、実行準備をしている
     $statement = $mysqli->prepare($query);

     //プレースホルダに値をセット
     $statement -> bindvalue(':id',$request);


     // ----------
     // 戻り値を作成
     // ----------
     // クエリに値をセット
     $response = $statement->execute();

     //SQLエラーの場合->エラーを表示
     if($response===false){
         echo 'エラーメッセージ:' .$mysqli->error . "\n";
     }

     // ----------
     // 後処理
     // ----------
     // DB接続を解放
     $statement->close();
     $mysqli->close();

     return $response;
 }