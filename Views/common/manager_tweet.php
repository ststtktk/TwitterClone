<div class="tweet">
    <div class="user">
        <a href="manager_profile.php?user_id=<?php echo htmlspecialchars($view_tweet['user_id']); ?>">
            <img src="<?php echo buildImagePath($view_tweet['user_image_name'], 'user'); ?>" alt="">
        </a>
    </div>
    <div class="content">
        <div class="name">
            <a href="manager_profile.php?user_id=<?php echo htmlspecialchars($view_tweet['user_id']); ?>">
                <span class="nickname"><?php echo htmlspecialchars($view_tweet['user_nickname']); ?></span>
                <span class="user-name">@<?php echo htmlspecialchars($view_tweet['user_name']); ?> ・<?php echo convertToDayTimeAgo($view_tweet['tweet_created_at']); ?></span>
            </a>
        </div>
        <form action="tweet_edit.php" method="post" class="editbtn" onsubmit="return confirm_edit()">
            <input type="hidden" value="<?php echo htmlspecialchars($view_tweet['tweet_id']) ?>" name="tweet_id">

            <textarea name="tweet_body" class=""><?php echo $view_tweet['tweet_body'] ?></textarea>
            <p class="tweetedit"><?php echo $view_tweet['tweet_edit'] ?></p>

            <?php if(isset($view_tweet['tweet_image_name'])): ?>
                <img src="<?php echo buildImagePath($view_tweet['tweet_image_name'],'tweet'); ?>" alt="" class="post-image">
            <?php endif;?>
            <button type="submit" class="edit" name="edit_tweet">編集</button>
        </form>
        <div class="icon-list">
            <div class="like js-like" data-tweet-id="<?php echo htmlspecialchars($view_tweet['tweet_id']); ?>" data-like-id="<?php echo htmlspecialchars($view_tweet['like_id']); ?>">
                <?php
                if(isset($view_tweet['like_id'])){//isset関数は変数に値がセットされているかを確認
                    //いいねしている場合、青のハート
                    echo '<img src="'.HOME_URL.'Views/img/icon-heart-twitterblue.svg" alt="">';
                }else{
                    //いいねしていない場合、グレーのハート
                    echo '<img src="'.HOME_URL.'Views/img/icon-heart.svg" alt="">';
                }
                ?>
            </div>
            <div class="like-count js-like-count"><?php echo $view_tweet['like_count'];?></div>
            <!--リプライ遷移-->
            <div class="like">
                <a href="manager_reply.php?tweet_id=<?php echo htmlspecialchars($view_tweet['tweet_id']); ?>" class=""><img src="<?php echo HOME_URL;?>Views/img/reply.png" alt="リプライ画像" class=""></a>
            </div>
            <form action="delete.php" method="post" class="deletebtn" onsubmit="return confirm_delete()">
                <div class="delete-area">
                    <input type="hidden" value="<?php echo htmlspecialchars($view_tweet['tweet_id']) ?>" name="tweet_id">
                    <button type="submit" class="edit" name="delete_tweet">削除</button>
                </div>
            </form> 
        </div>
    </div>
</div>
