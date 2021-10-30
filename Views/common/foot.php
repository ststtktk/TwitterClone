<script>
    document.addEventListener('DOMContentLoaded', function() {
        /* DOMContentLoadedイベントは、DOMの読み込み(htmlの読み込み)が完了してからfunctionが実行されるもの
            popoverを有効にするにはJavaScirptに埋め込んでおく必要がある
        */
        $('.js-popover').popover();
    }, false);
</script>