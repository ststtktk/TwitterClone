////
//いいね用のJavaScript
////

$(function(){
    //いいねがクリックされた時
    $('.js-like').click(function(){
        /*thisオブジェクトにはクリックされた要素が入る*/
        const this_obj = $(this);
        /* クリックされた要素のデータ属性のlike_idがここに入る */
        const like_id  = $(this).data('like-id');
        /* クリック要素の中にあるjs-like-countクラスの要素が[like_count_obj]に入る*/
        /* parentメソッドは、１つ上の階層である親要素を取得*/
        const like_count_obj = $(this).parent().find('.js-like-count');
        /* js_like_count要素からいいね数を取得 */
        /* Numberで()の値を数値に変換*/
        /* html（）でマッチした１つ目の要素のhtmlを返す*/
        let like_count = Number(like_count_obj.html());

        if(like_id){//like_idが既にある場合
            //いいね！取り消し
            //いいね！カウントを減らす
            like_count--;
            like_count_obj.html(like_count);//いいね数の要素に更新したいいね数をセットしている
            this_obj.data('like-id',null);//クリック要素のデータ属性のlike_idを削除します

            //いいね！ボタンの色をグレーに変更
            $(this).find('img').attr('src','../Views/img/icon-heart.svg');
        }else{
            //いいね！付与
            //いいね！カウントを増やす
            like_count++;
            like_count_obj.html(like_count);
            this_obj.data('like-id',true);

            //いいね！ボタンの色を青色に変更
            $(this).find('img').attr('src','../Views/img/icon-heart-twitterblue.svg');
        }
;
    })
})