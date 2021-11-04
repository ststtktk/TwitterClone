<?php
///////
//　便利な関数
///////

/**
 * 画像ファイル名から画像のURLを生成する
 * 
 * @param string $name 第一引数には画像ファイル名が入ってくる想定
 * @param string $type user | tweet 第二引数にはユーザーアイコンの画像なのかつぶやき投稿の画像なのかを識別するタイプが入る想定
 * @return string 戻り値はURLを返すので、ストリングになる
 * 
 */

function buildImagePath(string $name = null,string $type)
{/* $nameに値が渡されなかったら、nullを返す*/
    if($type === 'user' && !isset($name)){/*タイプがユーザーでファイルが存在しない場合*/
        return HOME_URL . 'Views/img/icon-default-user.svg';
    }

    return HOME_URL . 'Views/img_uploaded/' .$type. '/' . htmlspecialchars($name);
    /*ファイル名はhtmlspecialchairsでエスケープしておく。htmlspecialchars関数は、phpでエスケープ処理するための関数*/

}

/** 
 *　指定した日時からどれだけ経過したかを取得

 * @param string $datetime 日時 //パラムタグは、引数の情報
 * @return string　　　　　　　　 //リターンタグは、戻り値の情報
*/
function convertTodayTimeAgo(string $datetime)//stringで型を指定しておくと、指定した型以外が入るとエラーを表示
{
    $unix = strtotime($datetime);
    //strtotime関数で日時をUNIXタイムに変換。UNIXタイムとは、1970/01/01 0時からの経過秒数。
    $now = time();//time関数はUNIXタイム開始から現在までの秒数を返す。
    $diff_sec = $now - $unix;//現代のUNIXタイムから投稿日時のUNIXタイムをひくと経過秒数が求めれる

    if($diff_sec < 60){
        $time = $diff_sec;
        $unit = '秒前';
    }elseif($diff_sec < 3600){
        $time = $diff_sec /60;
        $unit = '分前';
    } elseif($diff_sec < 86400){
        $time = $diff_sec / 3600;
        $unit = '時間前';
    }elseif($diff_sec < 2764800){
        $time = $diff_sec / 86400;
        $unit = '日前';
    }else{

        if(date('Y') !== date('Y',$unix)){//現在の年と投稿日時の年が異なるなら
            $time = date('Y年n月j日',$unix);
        }else{
            $time = date('n月j日',$unix);
        }
        return $time;
    }

    return (int)$time . $unit;//intは型キャストと言って、型を変換する処理。　
}

/**
 * ユーザー情報をセッションに保存
 *
 * @param array $user
 * @return void
 */
function saveUserSession(array $user)
{
    //セッションを開始していない場合 session_statusで現在のセッションの状態をチェックする
    //PHP_SESSION_NONEは、セッションが有効だけれどもセッションが存在しない場合の session_status() の戻り値。
    if (session_status() === PHP_SESSION_NONE) {
        // セッション開始
        session_start();
    }
    //引数のuser変数をSESSIONのUSERというキーのところに格納
    $_SESSION['USER'] = $user;
}
 
/**
 * ユーザー情報をセッションから削除
 *
 * @return void
 */
function deleteUserSession()
{
    // セッションを開始していない場合
    if (session_status() === PHP_SESSION_NONE) {
        // セッション開始
        session_start();
    }
 
    //unset関数で、セッションのユーザー情報を削除
    unset($_SESSION['USER']);
}

 /** 
 * セッションのユーザー情報を取得
 * 
 * @return array|false
 */
function getUserSession()
{
    // セッションを開始していない場合
    if (session_status() === PHP_SESSION_NONE) {
        // セッション開始
        session_start();
    }
 
    if (!isset($_SESSION['USER'])) {
        // セッションにユーザー情報がない
        return false;
    }
 
    $user = $_SESSION['USER'];
 
    // 画像のファイル名からファイルのURLを取得
    if (!isset($user['image_name'])) {
        $user['image_name'] = null;
    }
    $user['image_path'] = buildImagePath($user['image_name'], 'user');
 
    return $user;
}

/**
 * ユーザー情報をセッションに保存
 * 
 * @param array $user
 * @param array $file
 * @param string $type
 * @return string 画像のファイル名
 */

//引数はユーザー情報とアップロードされたファイル情報、ユーザーアイコンかつぶやきの画像かを
function uploadImage(array $user, array $file, string $type)
{
    //画像のファイルから拡張子を取得(例:png)
    //strrchr:文字列内で最後に出現する文字列の位置を検索し、末尾までの全ての文字を取得
    $image_extension = strrchr($file['name'], '.');

    //画像のファイル名を取得(YmdHis:2021-01-01 00:00:00 ならば　20210101000000)
    //date('YmdHis')には現在の日持がはいる
    $image_name = $user['id']. '_' . date('YmdHis') . $image_extension;
    
    //保存先のディレクトリ
    //$typeには、ユーザーかツイートの文字列がはいる
    $directory = '../Views/img_uploaded/' . $type . '/';

    //画像のパス
    $image_path = $directory . $image_name;

    //画像を設置
    //move_uploaded_fileでアップロードされた、一時的ファイルを指定の場所に移動します
    move_uploaded_file($file['tmp_name'],$image_path);

    //画像のファイルの場合->ファイル名をreturn
    if(exif_imagetype($image_path)){
        return $image_name;
    }

    //画像ファイル以外の場合
    echo '選択されたファイルが画像ではないため処理を停止しました。';
    exit;
}

