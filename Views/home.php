<?php
include_once('../config.php');
include_once('../util.php');

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

?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../Views/common/head.php');?>
    <title>ホーム画面 / Twitterクローン</title>
    <meta name="description" content="ホーム画面です">
</head>

<body class="home">
    <div class="container"><!-- containerクラスは、レスポンシブウェブデザインが適用される -->
        <?php include_once('../Views/common/side.php');?>
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
                <p class="p-3">ツイートがありません</p><!--classのp-3はpaddingのことで、全方向に１レムの余白を開ける。bootstrapのクラす-->
            <?php else: ?>
                <div class="tweet-list">
                <?php foreach($view_tweets as $view_tweet): ?>
                    <!--foreach内でinclude_onceしたときは、tweet.phpが最初の1件分しか実行されないので、onceを外す-->
                    <?php include('../Views/common/tweet.php');?>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include_once('../Views/common/foot.php');?>
    
</body>
</html>