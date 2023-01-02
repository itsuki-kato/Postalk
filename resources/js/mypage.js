$(function()
{
    // マイカテゴリには初期状態でチェックを入れる
    $('input[class="my_category"]').prop('checked', true);

    // チェックボックスの制御
    $('input[name="category_ids[]"]').on('click', function() {
        let count = $('input[name="category_ids[]"]:checked').length;

        if(count > 9) { // とりあえず登録できるカテゴリは10個までとする
            $('input[name="category_ids[]"]:not(:checked)').prop('disabled', true);
        } else if(count <= 9) {
            $('input[name="category_ids[]"]:not(:checked)').prop('disabled', false);
        }

        // 1つも選択されていなかったら更新ボタンを操作させない
        if(count == 0) {
            $('#user-category-update-btn').prop('disabled', true);
        } else if(count > 0) {
            $('#user-category-update-btn').prop('disabled', false);
        }
    });

    // 更新ボタン押下で確認ダイアログを表示する
    $('#user-category-update-btn').on('click', function() {
        if(!confirm('更新してよろしいですか？')) {
            return false;
        } else {
            // submitする
        }
    });
});
