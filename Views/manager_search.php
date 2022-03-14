<?php 
ini_set('display_errors',1);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../Views/common/head.php');?>
    <title>管理者検索画面 / Twitterクローン</title>
    <meta name="description" content="検索画面です">
</head>

<body class="home search text-center">
    <div class="container"><!-- containerクラスは、レスポンシブウェブデザインが適用される -->
        <?php include_once('../Views/common/manager_side.php');?>
        <div class="main">
            <div class="main-header">
                <h1>検索</h1>
            </div>

            <!--検索エリア-->
            <form action="manager_search.php" method="get">
                <div class="search-area">
                    <input type="text" class="form-control" placeholder="キーワード検索" name="keyword" value="<?php echo htmlspecialchars($view_keyword);?>">
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
                    <?php include('../Views/common/manager_tweet.php');?>
                <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <?php include_once('../Views/common/foot.php');?>
    
</body>
</html>