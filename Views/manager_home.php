<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../Views/common/head.php');?>
    <title>管理者画面 / Twitterクローン</title>
    <meta name="description" content="ホーム画面です">
</head>
<body class="home">
    <div class="container"><!-- containerクラスは、レスポンシブウェブデザインが適用される -->
        <?php include_once('../Views/common/manager_side.php');?>
        <div class="main">
            <div class="main-header">
                <h1>管理者ホーム</h1>
            </div>
            <!-- つぶやき投稿エリア -->
            <div class="tweet-post">
                <div class="my-icon">
                    <img src="<?php echo htmlspecialchars($view_user['image_path']) ?>" alt="">
                </div>
                <div class="input-area">
                </div>
            </div>
            <!--仕切りエリア-->
            <div class="ditch"></div>
        </div>
    </div>
    <?php include_once('../Views/common/foot.php');?>
</body>
</html>