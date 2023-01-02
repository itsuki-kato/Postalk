import exeAjax from './common/ajax_setup';

$(function()
{
    // TODO:フォロー許可、フォロー解除の処理もまとめる
    $('#follow-apply-btn,#follow-permit-btn,#follow-delete-btn').on('click', function()
    {
        // クリックしたボタンを取得
        let id = $(this).attr('id');

        let user_id = $(this).data('user-id');
        let follow_user_id = $(this).data('follow-user-id');

        let target_data = {
            user_id       : user_id,
            follow_user_id: follow_user_id
        }

        // クリックしたボタンによってSubmitするRouteを分ける
        let url = '';
        switch(id) {
            case 'follow-apply-btn':
                url = '/apply_follow';

                // フォロー申請が終わるまで解除ボタンをdisableにする
                $('#follow-delete-btn').prop('disabled', true);

                break;

            case 'follow-permit-btn':
                url = '/permit_follow';
                break;

            case 'follow-delete-btn':
                url = '/delete_follow';
                break;

            default:
                break;
        }

        exeAjax('POST', url, 'json', target_data)
        .then(
            function(data) // 成功した時
            {
                console.log('done');
                // サーバー側でフロントに通知したいエラーは表示する
                if(data.error) {
                    let error_message = data.error;
                    let elm = `<div class="text-danger">${error_message}</div>`;
                    $('.ajax_error_message').append(elm);
                }
                // ボタンを変更
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
        $('#follow-delete-btn').prop('disabled', false);
        return;
    }
});
