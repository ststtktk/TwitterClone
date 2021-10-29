<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link rel="icon" href="../Views/img/logo-twitterblue.svg">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <link rel="stylesheet" href="../Views/css/style.css">

    <title>会員登録画面 / Twitterクローン</title>
    <meta name="description" content="会員登録画面です">
</head>
<body class="signup text-center"><!--text-centerは中央よせ-->
    <main class="form-signup">
        <form action="sign-up.php" method="post">
            <img src="../Views/img/logo-white.svg" alt="" class="logo-white">
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
</body>
    
</html>