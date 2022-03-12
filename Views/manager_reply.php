<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../Views/common/head.php');?>
    <title>リプライ画面 / Twitterクローン</title>
    <meta name="description" content="リプライ画面です">
</head>

<body class="home">
    <div class="container"><!-- containerクラスは、レスポンシブウェブデザインが適用される -->
        <?php include_once('../Views/common/manager_side.php');?>
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
                                    <div class="tweet">
                                        <div class="content">
                                            <form action="reply_edit.php" method="post" class="editbtn" onsubmit="return confirm_edit()">
                                                <input type="hidden" value="<?php echo htmlspecialchars($reply['id']) ?>" name="reply_id">
                                                <textarea name="reply_body"><?php echo $reply['reply_body'] ?></textarea>
                                                <button type="submit" class="edit" >編集</button>
                                            </form>
                                            <form action="replydelete.php" method="post" class="deletebtn" onsubmit="return confirm_delete()">
                                                <div class="delete-area">
                                                    <input type="hidden" value="<?php echo htmlspecialchars($reply['id']) ?>" name="reply_id">
                                                    <input type="hidden" value="<?php echo htmlspecialchars($reply['tweet_id']) ?>" name="tweet_id">
                                                    <button type="submit" class="edit">削除</button>
                                                </div>
                                            </form> 
                                        </div>
                                    </div>
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