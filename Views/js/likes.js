////
//いいね用のJavaScript
////

$(function(){
    //いいねがクリックされた時
    $('.js-like').click(function(){
        /*thisオブジェクトにはクリックされた要素が入る*/
        const this_obj = $(this);
        // tweet-idを取得
        const tweet_id = $(this).data('tweet-id');
        /* クリックされた要素のデータ属性のlike_idがここに入る */
        const like_id  = $(this).data('like-id');
        /* クリック要素の中にあるjs-like-countクラスの要素が[like_count_obj]に入る*/
        /* parentメソッドは、１つ上の階層である親要素を取得*/
        const like_count_obj = $(this).parent().find('.js-like-count');
        /* js_like_count要素からいいね数を取得 */
        /* Numberで()の値を数値に変換*/
        /* html（）でマッチした１つ目の要素のhtmlを返す*/
        let like_count = Number(like_count_obj.html());

        if(like_id){
            //いいねがあれば、いいね！取り消し
            //非同期通信
            //jQueryのajaxメソッド(ページ遷移せずにページを読み込める仕組み.一部の情報をサーバーに送信して、それらを受け取り反映させる仕組み)を利用
            //.でメソッドを連結。この動きはajaxメソッドの戻り値にあるdoneメソッドが実行されて、doneメソッドの戻り値にあるfailメソッドが実行されてる
            $.ajax({
                url:'like.php',
                type:'POST',
                data:{
                    'like_id':like_id
                },
                timeout:10000 //サーバーとの通信のタイムアウト
            })
            //取り消しが成功
            //あくまでも、doneメソッドを実行して以下の処理を登録しておくだけ。サーバーからレスポンスが返ってきたタイミングで裏で実行される
            .done(() =>{
                //いいね！カウントを減らす
                like_count--;
                like_count_obj.html(like_count);//いいね数の要素に更新したいいね数をセットしている
                this_obj.data('like-id',null);//クリック要素のデータ属性のlike_idを削除します

                //いいね！ボタンの色をグレーに変更
                $(this).find('img').attr('src','../Views/img/icon-heart.svg');
            })
            //通信が正常に実行されなかった場合に実行される
            //あくまでも、failメソッドを実行して以下の処理を登録しておくだけ。サーバーからレスポンスが返ってきたタイミングで裏で実行される
            .fail((data) => {
                alert('処理中にエラーが発生しました。');
                console.log(data);
            });
        }else{
            //いいね！付与
            //非同期通信
            $.ajax({
                url:'like.php',
                type:'POST',
                data:{
                    'tweet_id':tweet_id
                },
                timeout:10000 //サーバーとの通信のタイムアウト
        })
            //いいね！が成功
            .done((data)=>{
            //いいね！カウントを増やす
            like_count++;
            like_count_obj.html(like_count);
            this_obj.data('like-id',data['like_id']);

            //いいね！ボタンの色を青色に変更
            $(this).find('img').attr('src','../Views/img/icon-heart-twitterblue.svg');
        })
            .fail((data) => {
            alert('処理中にエラーが発生しました。');
            console.log(data);
        });
        }
    });
})