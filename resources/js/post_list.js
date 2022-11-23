import exeAjax from './common/ajax_setup';

$(function() {
    // 投稿のアコーディオンを制御
    $('.card-open').on('click', function() {
        $(this).toggleClass('active');
        $(this).next('.card-inner').slideToggle();
    });

    // お気に入り登録処理
    $('.post_favorite_btn').on('click', function() {
        let favorite_post_id = $(this).data('favorite-post-id');
        let favorite_user_id = $(this).data('favorite-user-id');

        let target_data = {
            'favorite_post_id' : favorite_post_id,
            'favorite_user_id' : favorite_user_id
        };

        // Ajaxでお気に入り登録
        exeAjax('POST', '/Postalk/public/post/favorite', 'json', target_data)
        .done(function (result) { // 成功した時
            console.log('done');
            console.log(result.favorite_post_id);
        })
        .fail(function (jqXHR, textStatus, errorThrown) { // 失敗した時
            console.log("ajax通信に失敗しました")
            console.log(jqXHR.status);
            console.log(textStatus);
            console.log(errorThrown.message);
        });
    });

    // お気に入り登録後のボタンの色を変更
    function changeBtn(aaa) {
        console.log(aaa);
        let post_id = aaa.favorite_post_id;
        console.log(post_id);
        $('[data-favorite-post-id=' + '"' + post_id + '"' + ']').addClass("favorite_added");
        return;
    }
});
