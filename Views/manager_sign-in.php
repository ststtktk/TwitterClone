<!DOCTYPE html>
<html lang="ja">
<head>
    <?php include_once('../Views/common/head.php');?>
    <title>管理者ログイン画面 / Twitterクローン</title>
    <meta name="description" content="管理者ログイン画面です">
</head>
<body class="signup text-center">
    <main class="form-signup">
        <form action="manager_sign-in.php" method="post">
            <img src="<?php echo HOME_URL;?>Views/img/logo-white.svg" alt="" class="logo-white">
            <h1>管理者サイトにログイン</h1>
            <?php if (isset($view_try_login_result) && $view_try_login_result === false):?>
                <div class="alert alert-warning text-sm" role="alert">
                    ログインに失敗しました。メールアドレス、パスワードが正しいかご確認ください。
                </div>
            <?php endif; ?>
            <input type="email" class="form-control" name="email" placeholder="メールアドレス" maxlength="254" required　autofocus>
            <input type="password" class="form-control" name="password" placeholder="パスワ-ド" minlength="4" maxlength="128" required>
            <button type="submit" class="w-100 btn btn-lg">ログイン</button>
            <p class="mt-3 mb-2"><a href="sign-in.php">一般ログイン画面に戻る</a></p>
            <p class="mt-2 mb-3" text-muted>&copy; 2021</p>
        </form>
    </main>
    <?php include_once('../Views/common/foot.php');?>
</body>
    
</html>