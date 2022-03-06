<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../Views/common/head.php');?>
    <title>リプライ画面 / Twitterクローン</title>
    <meta name="description" content="リプライ画面です">
</head>

<body class="home">
    <div class="container"><!-- containerクラスは、レスポンシブウェブデザインが適用される -->
        <?php include_once('../Views/common/side.php');?>
        <div class="main">
            <div class="main-header">
                <h1>リプライ</h1>
            </div>
            <!--ツイート表示エリア -->
            <div class="tweet-post">
                <div class="input-area">
                    <div class="tweet-list">
                    <?php foreach($view_tweets as $view_tweet): ?>
                        <?php include('../Views/common/tweet.php');?>
                    <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!--仕切りエリア-->
            <div class="ditch"></div>

            <!--リプライ投稿エリア-->
            <div class="input-area">
                <form action="reply-post.php" method="post" enctype="multipart/form-data">
                    <textarea name="reply_body" placeholder="返信をツイート" maxlength="140"></textarea>
                    <input type="hidden" name="tweet_id" value="<?php echo $_GET['tweet_id']?>">
                    <div class="bottom-area">
                        <div class="mb-0">
                            <input type="file" name="image" class="form-control form-control-sm">
                        </div>
                        <button class="btn" type="submit">リプライする</button>
                    </div>
                </form>
            </div>

            <!--リプライ一覧エリア-->
            <div class="tweet-post">
                <div class="input-area">
                <?php echo $reply_tweet['reply_body'] ?>
                <?php foreach($view_tweets as $view_tweet): ?>
                    <div class="tweet">
                        <div class="user">
                            <p>アイコン</p>
                        </div>
                        <div class="content">
                            <div class="name">
                                <p>ニックネーム</p>
                            </div>
                            <p>ツイート内容</p>
                        </div>
                    </div>
                <?php endforeach; ?>
                </div>
            </div>

        </div>
    </div>


    <?php include_once('../Views/common/foot.php');?>
    
</body>
</html>