<?php
//エラー表示あり
ini_set('display_errors',1);
//日本時期にする
date_default_timezone_set('Asia/Tokyo');
//URL/ディレクトリ設定
define('HOME_URL','/TwitterClone/');

////////////////
// ツイート一覧
////////////////
$view_tweets = [//つぶやき一覧の内容を動的にするために、phpの配列にする
    [
        'user_id' => 1,//投稿者のID
        'user_name' => 'taro',//userのなまえ
        'user_nickname' => '太郎',//ニックネーム
        'user_image_name' => 'sample-person.jpg',//ユーザーのアイコン画像のファイル名
        'tweet_body' => '今プログラミングをしています。',//つぶやき本文
        'tweet_image_name' =>null,//投稿画像
        'tweet_created_at' =>'2021-07-01 14:00:00',//投稿日時
        'like_id' => null,//自分がいいねしていたら入ってくるID
        'like_count' => 0,//いいねの数
    ],
    [
        'user_id' => 2,//投稿者のID
        'user_name' => 'jiro',//userのなまえ
        'user_nickname' => '次郎',//ニックネーム
        'user_image_name' => null,//ユーザーのアイコン画像のファイル名
        'tweet_body' => 'コワーキングスペースをオープンしました',//つぶやき本文
        'tweet_image_name' =>'sample-post.jpg',//投稿画像
        'tweet_created_at' =>'2021-07-11 14:00:00',//投稿日時
        'like_id' => 1,//自分がいいねしていたら入ってくるID
        'like_count' => 1,//いいねの数
    ]
];

///////
//　便利な関数
///////

/**
 * 画像ファイル名から画像のURLを生成する
 * 
 * @param string $name 画像ファイル
 * @param string $type user | tweet
 * @return string
 * 
 */

function buildImagePath(string $name = null,string $type)
{
    if($type === 'user' && !isset($name)){
        return HOME_URL . 'Views/img/icon-default-user.svg';
    }

    return HOME_URL . 'Views/img_uploaded/' .$type. '/' . htmlspecialchars($name);
    /*htmlspecialchars関数は、phpでエスケープ処理するための関数*/

}



/** 
 *　指定した日時からどれだけ経過したかを取得

 * @param string $datetime 日時 //引数の情報
 * @return string　　　　　　　　 //戻り値の情報
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


<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="<?php echo HOME_URL;?>Views/img/logo-twitterblue.svg">
    <!-- Bootstrap only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="<?php echo HOME_URL;?>Views/css/style.css">
    <title>ホーム画面 / Twitterクローン</title>
    <meta name="description" content="ホーム画面です">
</head>
<body class="home">
    <div class="container">
        <div class="side">
            <div class="side-inner">
                <ul class="nav flex-column">
                    <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/logo-twitterblue.svg" alt="サイトロゴ画像" class="icon"></a></li>
                    <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-home.svg" alt=""></a></li>
                    <li class="nav-item"><a href="search.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-search.svg" alt=""></a></li>
                    <li class="nav-item"><a href="notification" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-notification.svg" alt=""></a></li>
                    <li class="nav-item"><a href="profile.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-profile.svg" alt=""></a></li>
                    <li class="nav-item"><a href="post.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-post-tweet-twitterblue.svg" alt="" class="post-tweet"></a></li>
                    <li class="nav-item my-icon"><img src="<?php echo HOME_URL;?>Views/img_uploaded/user/sample-person.jpg" alt=""></li>
                </ul>
            </div>
        </div>
        <div class="main">
            <div class="main-header">
                <h1>ホーム</h1>
            </div>
            <!--
                 # + id名 + Tabキー = <div id="first"></div>
                 . + class名 + Tabキー = <div class="cls"></div>
            -->
            <!-- つぶやき投稿エリア -->
            <div class="tweet-post">
                <div class="my-icon">
                    <img src="<?php echo HOME_URL;?>Views/img_uploaded/user/sample-person.jpg" alt="">
                </div>
                <div class="input-area">
                    <form action="post.php" method="post" enctype="multipart/form-data">
                        <textarea name="body" placeholder="いまどうしてる？" maxlength="140"></textarea>
                        <div class="bottom-area">
                            <div class="mb-0">
                                <input type="file" name="image" class="form-control form-control-sm">
                            </div>
                            <button class="btn" type="submit">つぶやく</button>
                        </div>
                    </form>
                </div>
            </div>

            <!--仕切りエリア-->
            <div class="ditch"></div>

            <!--つぶやき一覧エリア-->
            <?php if(empty($view_tweets)): ?><!--エンプティー関数は第１引数の値が空だった場合　trueを返す-->
                <p class="p-3">ツイートがありません</p><!--classのp-3は全方向に１レムの余白を開ける。bootstrapのクラす-->
            <?php else: ?>
                <div class="tweet-list">
                <?php foreach($view_tweets as $view_tweet): ?>
                    <div class="tweet">
                        <div class="user">
                            <a href="profile.php?user_id=<?php echo htmlspecialchars($view_tweet['user_id']); ?>">
                                <img src="<?php echo buildImagePath($view_tweet['user_image_name'], 'user'); ?>" alt="">
                            </a>
                        </div>
                        <div class="content">
                                <div class="name">
                                    <a href="profile.php?user_id=<?php echo htmlspecialchars($view_tweet['user_id']); ?>">
                                        <span class="nickname"><?php echo htmlspecialchars($view_tweet['user_nickname']); ?></span>
                                        <span class="user-name">@<?php echo htmlspecialchars($view_tweet['user_name']); ?> ・<?php echo convertToDayTimeAgo($view_tweet['tweet_created_at']); ?></span>
                                    </a>
                                </div>
                            <p><?php echo $view_tweet['tweet_body']?></p>

                            <?php if(isset($view_tweet['tweet_image_name'])): ?>
                                <img src="<?php echo buildImagePath($view_tweet['tweet_image_name'],'tweet'); ?>" alt="" class="post-image">
                            <?php endif;?>

                            <div class="icon-list">
                                <div class="like">
                                    <?php
                                    if(isset($view_tweet['like_id'])){
                                        //いいねしている場合、青のハート
                                        echo '<img src="'.HOME_URL.'Views/img/icon-heart-twitterblue.svg" alt="">';
                                    }else{
                                        //いいねしていない場合、グレーのハート
                                        echo '<img src="'.HOME_URL.'Views/img/icon-heart.svg" alt="">';
                                    }
                                    ?>
                                </div>
                                <div class="like-count"><?php echo $view_tweet['like_count'];?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>