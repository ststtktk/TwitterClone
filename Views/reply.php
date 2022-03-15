<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../Views/common/head.php');?>
    <title>リプライ画面 / Twitterクローン</title>
    <meta name="description" content="リプライ画面です">
</head>
<body class="home">
    <div class="container">
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
            <div class="tweet-post">
                <div class="input-area">
                    <form action="reply-post.php" method="post" enctype="multipart/form-data">
                        <textarea name="reply_body" placeholder="返信をツイート" maxlength="140"></textarea>
                        <input type="hidden" name="tweet_id" value="<?php echo $_GET['tweet_id']?>">
                        <div class="bottom-area">
                            <button class="btn" type="submit">リプライする</button>
                        </div>
                    </form>
                </div>
            </div>
            <!--リプライ一覧エリア-->
            <div class="tweet-post">
                <div class="input-area">
                    <div class="tweet-list">
                        <?php foreach($reply_tweet as $reply): ?>
                            <div class="tweet">
                                <div class="user">
                                    <a href="profile.php?user_id=<?php echo htmlspecialchars($reply['user_id']); ?>">
                                        <img src="<?php echo buildImagePath($reply['image_name'], 'user'); ?>" alt="">
                                    </a>
                                </div>
                                <div class="content">
                                    <div class="name">
                                        <span>
                                            <p><?php echo $reply['nickname'] ?>・<?php echo convertToDayTimeAgo($reply['created_at']) ?></p>
                                        </span>
                                    </div>
                                    <!-- 削除された場合 -->
                                    <?php if(in_array('管理者により削除されました。',$reply)):?>
                                        <p><?php echo $reply['reply_body'] ?></p>
                                        <p class="tweetedit"><?php echo $reply['edit'] ?></p>
                                    <!-- 削除以外の場合 -->
                                    <?php else: ?>                                    
                                        <p><?php echo $reply['reply_body'] ?></p>
                                        <p class="tweetedit"><?php echo $reply['edit'] ?></p>
                                    <?php endif; ?>
                                </div>
                            </div> 
                        <?php endforeach; ?>
                    </div> 
                </div>
            </div>

        </div>
    </div>
    <?php include_once('../Views/common/foot.php');?>
</body>
</html>