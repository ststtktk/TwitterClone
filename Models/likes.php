<?php
/////
//いいね！データを処理
/////

/**
 * いいね！を作成
 * 
 * @param array $data
 * @return int|false
 */
function createLike(array $data)//引数は配列。戻り値は成功はint型、失敗はfalse
{
    //DB接続 mysqli関数でデータベースと接続する。$mysqliに接続結果のオブジェクトが入ってくる。
    $mysqli = new mysqli(DB_HOST,DB_USER,DB_PASSWORD,DB_NAME);
    if($mysqli->connect_errno){
        echo 'MySQLの接続に失敗しました。:'. $mysqli->connect_error . "\n";
        exit;
    }

    //----------
    //SQLクエリを作成(登録)
    //----------
    // likesテーブルにuser_idとtweet_idをセット
    $query = 'INSERT INTO likes (user_id,tweet_id) VALUES(?,?)';
    // SQLをprepare statementにセット
    $statement = $mysqli->prepare($query);

    //プレースホルダに値をセット
    $statement -> bind_param('ii',$data['user_id'],$data['tweet_id']);


    //----------
    //戻り値を作成
    //----------
    //クエリを実行し、SQLエラーでない場合。$statement(プリペアードステートメント)のexecuteメソッドで実行
    if($statement -> execute()){
        //問題なく実行できれば、戻り値用の変数にセット：インサートID(likes.id)
        $response = $mysqli->insert_id;
    }else {
        //戻り値用の変数にセット：失敗
        $response = false;
        echo 'エラーメッセージ:' .$mysqli->error . "\n";
    }

    //----------
    //後処理
    //----------
    //DB接続を解放
    $mysqli->close();
    $statement->close();

    return $response;
}

/**
 * いいね！を取り消し
 * 
 * @param array $data
 * @return bool
 */

 function deleteLike(array $data)
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
     $query = 'UPDATE likes SET status ="deleted" WHERE id = ? AND user_id = ?';
     // $mysqli(DB)にアクセスして、実行準備をしている
     $statement = $mysqli->prepare($query);

     //プレースホルダに値をセット
     $statement -> bind_param('ii',$data['like_id'],$data['user_id']);


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