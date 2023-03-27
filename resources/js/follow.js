import exeAjax from './common/ajax_setup';

$(function()
{
    // NOTE：$(セレクタ).on(...)の書き方だと動的に生成した要素に対してイベントが動かない
    $(document).on('click', '#follow-apply-btn,#follow-permit-btn,#follow-delete-btn', function() {
        // クリックしたボタンによってSubmitするRouteを分ける
        
        // phpに送信する値をオブジェクトで定義する
        let target_data = {
            user_id        : $(this).data('user-id'),
            follow_user_id : $(this).data('follow-user-id'),
            btn_id         : $(this).attr('id')
        }

        exeAjax('POST', getUrl(target_data.btn_id), 'json', target_data)
        .then(
            function(data) // 通信が成功した場合
            {
                // php側で通信以外のエラーメッセージを送信した場合は出力する
                if(data.error) {
                    let error_message = data.error;
                    let elm = `<div class="text-danger">${error_message}</div>`;
                    $('.ajax_error_message').append(elm);
                }

                // #follow-btnの中身を一度空にする
                $('#follow-btn').empty();
                // 取得したbuttonタグを再描写する
                $('#follow-btn').append(getBtnElement(data));

            },
            function() // 通信が失敗した場合
            {
                console.log('ajax通信に失敗しました');
                console.log(jqXHR.status);
                console.log(textStatus);
                console.log(errorThrown.message);
            }
        );
    });

    // ユーザーが操作した　buttonのidによって送信先のRoute(url)を取得する
    function getUrl(btn_id) {
        let url = '';

        switch(btn_id) {
            // フォロー申請の場合
            case 'follow-apply-btn':
                url = '/apply_follow';
                break;

            // フォロー許可の場合
            case 'follow-permit-btn':
                url = '/permit_follow';
                break;

            // フォロー解除の場合
            case 'follow-delete-btn':
                url = '/delete_follow';
                break;

            default:
                // Nothing
                break;
        }

        return url;
    }

    // AjaxのResponseに含まれるユーザーが操作したbuttonタグのidによって再描写するボタンを振り分ける
    function getBtnElement(data) {
        // buttonタグに挿入する要素の定義
        let slot_id             = '';
        let slot_user_id        = '';
        let slot_follow_user_id = '';
        let slot_btn_name       = '';

        
        // ユーザーが押下したボタンのidをAjaxのResponseから取得する
        let btn_id = data.btn_id;

        switch(btn_id) {
            // 申請ボタンのときは解除ボタンを表示する
            case 'follow-apply-btn':
                slot_id             = 'follow-delete-btn';
                slot_user_id        = data.user_id;
                slot_follow_user_id = data.follow_user_id;
                slot_btn_name       = 'フォロー解除';
                break;
                
            // 解除ボタンのときは申請ボタンを表示する
            case 'follow-delete-btn':
                slot_id             = 'follow-apply-btn';
                slot_user_id        = data.user_id;
                slot_follow_user_id = data.follow_user_id;
                slot_btn_name       = 'フォロー申請';
                break;
            
            // 許可ボタンのときはnullを返す(消えたままでいい)
            case 'follow-permit-btn':
            default:
                return null;
        }

        // buttonタグの定義(slot_にcaseで振り分けた値が入る)
        let btn_elm = 
            ` <button 
                type="button"
                id="${slot_id}"
                data-user-id="${slot_user_id}" 
                data-follow-user-id="${slot_follow_user_id}" 
                class="btn btn-outline-primary">
                ${slot_btn_name}
            </button>`;

        return btn_elm;
    }
});
