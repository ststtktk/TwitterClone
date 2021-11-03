<?php
////ホームコントローラー////

//設定を読み込み
include_once '../config.php';
//便利な関数を読み込み
include_once '../util.php';


//ログインチェック
$user = getUserSession();
if(!$user){//変数userに値がなければログインしていない事になる
    //ログインしていない
    //header関数はブラウザに命令ができる。Locationという命令は、下記にかいたURLに遷移させるという内容
    header('Location: ' . HOME_URL . 'Controllers/sign-in.php');
    exit;
}

//表示用の変数
$view_user = $user;
//ツイート一覧
//TODO:モデルから取得
$view_tweets = [//つぶやき一覧の内容を動的にするために、phpの配列にする
    [
        'user_id' => 1,//投稿者のID
        'user_name' => 'taro',//userのなまえ
        'user_nickname' => '太郎',//ニックネーム
        'user_image_name' => 'sample-person.jpg',//ユーザーのアイコン画像のファイル名
        'tweet_body' => '今プログラミングをしています。',//つぶやき本文
        'tweet_image_name' =>null,//投稿画像
        'tweet_created_at' =>'2021-07-01 14:00:00',//投稿日時
        'like_id' => null,//自分がいいねしていたら入ってくるID
        'like_count' => 0,//いいねの数
    ],
    [
        'user_id' => 2,//投稿者のID
        'user_name' => 'jiro',//userのなまえ
        'user_nickname' => '次郎',//ニックネーム
        'user_image_name' => null,//ユーザーのアイコン画像のファイル名
        'tweet_body' => 'コワーキングスペースをオープンしました',//つぶやき本文
        'tweet_image_name' =>'sample-post.jpg',//投稿画像
        'tweet_created_at' =>'2021-07-11 14:00:00',//投稿日時
        'like_id' => 1,//自分がいいねしていたら入ってくるID
        'like_count' => 1,//いいねの数
    ]
];

//画面表示
include_once '../Views/home.php';
