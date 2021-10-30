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
?>