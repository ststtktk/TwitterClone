//////////
// フォロー用のJavaScript
//////////

$(function(){ // jQueryの記法でhtmlの解析が完了するまで、この中に書いた処理は実行されない
    $('.js-follow').click(function(){
        const this_obj = $(this); // thisにはクリックした要素が入る
        const followed_user_id = $(this).data('followed-user-id'); //クリックした要素のデータ属性、followed-user-idを取得
        const follow_id = $(this).data('follow-id'); // クリックした要素のデータ属性、follow-idを取得 
        cache:false
        if(follow_id){
            // フォロー取り消し
            // jQueryのajaxメソッド(ページ遷移せずにページを読み込める仕組み.一部の情報をサーバーに送信して、それらを受け取り反映させる仕組み)を利用
            // .でメソッドを連結。この動きはajaxメソッドの戻り値にあるdoneメソッドが実行されて、doneメソッドの戻り値にあるfailメソッドが実行されてる
            $.ajax({
                // Controllersのfollow.php
                url:'follow.php', 
                // methodはPOST
                type:'POST', 
                // 送るデータはfollow_id
                data:{
                    'follow_id':follow_id
                }, 
                timeout: 10000 // サーバーとの通信のタイムアウト
            })
            // 取り消し成功
            .done(()=>{
                // フォローボタンを白にする
                this_obj.addClass('btn-reverse');
                // フォローボタンの文言変更
                this_obj.text('フォローする');
                // フォローIDを削除
                this_obj.data('follow-id',null);
            })
            // 取り消し失敗
            .fail((data)=>{
                alert('処置中にエラーが発生しました。');
                console.log(data);
            });
        } else{
            // フォローする
            $.ajax({
                url:'follow.php',
                type:'POST',
                data:{
                    'followed_user_id':followed_user_id
                },
                timeout: 10000
            })
            // フォロー成功
            .done((data) => {
                // フォローボタンを青にする
                this_obj.removeClass('btn-reverse');
                // フォローボタンの文言変更
                this_obj.text('フォローを外す');
                // フォローIDを付与
                this_obj.data('follow-id',data['follow_id']);
            })
            // フォロー失敗
            .fail((data) => {
                alert('処置中にエラーが発生しました。');
                console.log(data);
            });
        }
    })
});