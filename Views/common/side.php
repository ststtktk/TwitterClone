<div class="side">
    <div class="side-inner">
        <ul class="nav flex-column"><!-- flex-columnクラスは子要素を上から下に並べる -->
        <!-- navクラスはメニュー項目に適したレイアウトが適用される -->
            <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/logo-twitterblue.svg" alt="サイトロゴ画像" class="icon"></a></li>
            <li class="nav-item"><a href="home.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-home.svg" alt=""></a></li>
            <li class="nav-item"><a href="search.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-search.svg" alt=""></a></li>
            <li class="nav-item"><a href="notification.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-notification.svg" alt=""></a></li>
            <li class="nav-item"><a href="profile.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-profile.svg" alt=""></a></li>
            <li class="nav-item"><a href="post.php" class="nav-link"><img src="<?php echo HOME_URL;?>Views/img/icon-post-tweet-twitterblue.svg" alt="" class="post-tweet"></a></li>
            <li class="nav-item my-icon"><img src="<?php echo htmlspecialchars($view_user['image_path']);?>" alt="" class="js-popover"
            data-bs-container="body" 
            data-bs-toggle="popover" 
            data-bs-placement="right" 
            data-bs-html="true" 
            data-bs-content="<a href='profile.php'>プロフィール</a><br><a href='sign-out.php'>ログアウト</a>">
            </li>
            <!-- 
            データオプションでポップオーバーの処理にオプションを指定できる.
            コンテナオプションにボディを指定することで、親要素のスタイルの影響を受けにくくなる。
            toggleオプションでポップオーバーを指定して、初期化。ボタンクリック時にポップを表示。
            placementオプションでライトを指定して、ポップを右側に配置。
            htmlオプションにtrueを指定することで、次に記述するcontentオプションをhtml化する。
            contentオプションに、ポップオーバーで表示するhtmlをかく。
            -->
        </ul>
    </div>
</div>