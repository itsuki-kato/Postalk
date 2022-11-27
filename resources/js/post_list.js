import exeAjax from './common/ajax_setup';

$(function()
{
    // 投稿のアコーディオンを制御
    $('.card-open').on('click', function()
    {
        $(this).toggleClass('active');
        $(this).next('.card-inner').slideToggle();
    });

    // お気に入り登録処理
    $('.post_favorite_btn').on('click', function()
    {
        let favorite_post_id = $(this).data('favorite-post-id');
        let favorite_user_id = $(this).data('favorite-user-id');

        let target_data = {
            'favorite_post_id' : favorite_post_id,
            'favorite_user_id' : favorite_user_id
        };

        // Ajaxでお気に入り登録or削除
        exeAjax('POST', '/Postalk/public/post/favorite', 'json', target_data)
        .then(
            function(data) // 成功した時
            {
                console.log('done');

                // サーバー側でフロントに通知したいエラーは表示する
                if(data.error)
                {
                    let error_message = data.error;
                    let elm = `<div class="text-danger">${error_message}</div>`;
                    $('.ajax_error_message').append(elm);
                }

                // ボタンの色を変更
                changeBtn(data);
            },
            function() // 失敗した時
            {
                console.log('ajax通信に失敗しました');
                console.log(jqXHR.status);
                console.log(textStatus);
                console.log(errorThrown.message);
            }
        );
    });

    // お気に入り登録/削除後のボタンの色を変更
    function changeBtn(data)
    {
        if(data.exists == false)
        {
            $(`[data-favorite-post-id="${data.favorite_post_id}"]`).addClass('post_favorite_btn_added');
        }
        else
        {
            $(`[data-favorite-post-id="${data.favorite_post_id}"]`).removeClass('post_favorite_btn_added');
        }
        return;
    }
});
