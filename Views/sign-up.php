<?php
include_once('../config.php');
include_once('../util.php');
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../Views/common/head.php');?>
    <title>会員登録画面 / Twitterクローン</title>
    <meta name="description" content="会員登録画面です">
</head>
<body class="signup text-center"><!--text-centerは中央よせ-->
    <main class="form-signup">
        <form action="sign-up.php" method="post">
            <img src="<?php echo HOME_URL;?>Views/img/logo-white.svg" alt="" class="logo-white">
            <h1>アカウントを作る</h1>
            <!--form controlはモダンなデザインになる。maxlengthで入力可能な文字数を指定。requiredで入力必須項目にする。autofacusで最初からこの項目を選択。-->
            <input type="text" class="form-control" name="nickname" placeholder="ニックネーム" maxlength="50" required autofocus>
            <input type="text" class="form-control" name="name" placeholder="ユーザー名、例)techis132" maxlength="50" required>
            <input type="email" class="form-control" name="email" placeholder="メールアドレス" maxlength="254" required>
            <input type="password" class="form-control" name="password" placeholder="パスワ-ド" minlength="4" maxlength="128" required>
            <!-- w-100はmax-width100%の意味。btn-lgは大きいボタン(lgはlarge)。 -->
            <button type="submit" class="w-100 btn btn-lg">登録する</button>
            <!-- mt-3はmargin-top=1rem、mb-2はmargin-bottomm=0.5remを意味 -->
            <p class="mt-3 mb-2"><a href="sign-in.php">ログインする</a></p>
            <!-- text-mutedは文字を灰色にする-->
            <p class="mt-2 mb-3" text-muted>&copy; 2021</p>
        </form>
    </main>
    <?php include_once('../Views/common/foot.php');?>
</body>
    
</html>