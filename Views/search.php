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
    <title>検索画面 / Twitterクローン</title>
    <meta name="description" content="検索画面です">
</head>

<body class="home search text-center">
    <div class="container"><!-- containerクラスは、レスポンシブウェブデザインが適用される -->
        <?php include_once('../Views/common/side.php');?>
        <div class="main">
            <div class="main-header">
                <h1>検索</h1>
            </div>

            <!--検索エリア-->
            <form action="search.php" method="get">
                <div class="search-area">
                    <input type="text" class="form-control" placeholder="キーワード検索" name="キーワード" value="">
                    <button type="submit" class="btn">検索</button>
                </div>
            </form>

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