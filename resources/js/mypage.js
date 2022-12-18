import exeAjax from './common/ajax_setup';

$(function()
{
    // TODO:フロント側の実装
    $('').on('click', function()
    {
        let user_id = $(this).data('user-id');
        let follow_user_id = $(this).data('follow-user-id');

        let target_data = {
            user_id       : user_id,
            follow_user_id: follow_user_id
        }

        exeAjax('POST', `/Postalk/pubic/user/follw_user`, 'json', target_data)
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
            function(data) // 失敗した時
            {
                console.log('ajax通信に失敗しました');
                console.log(jqXHR.status);
                console.log(textStatus);
                console.log(errorThrown.message);
            }
        );
    });

    function changeBtn(data)
    {
        if(data.exists == false)
        {
            $(`[data-follow-user-id="${data.follow_user_id}"]`).addClass('user_follow_btn_added');
        }
        else
        {
            $(`[data-follow-user-id="${data.follow_user_id}"]`).removeClass('user_follow_btn_added');
        }
        return;
    }
});
