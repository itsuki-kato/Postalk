/**
 * Ajax通信用メソッド
 * NOTE:Ajax成功可否と戻り値は呼び出し先で取得する。
 *
 * @param string method(POST or GET)
 * @param string url
 * @param string data_type
 * @param mixed data
 */
export default function exeAjax(method = "", url = "", data_type = "", data = "")
{
    // post送信の場合はcsrf-tokenが必須。ajaxSetup()でデフォルト値を指定。
    if (method == 'POST')
    {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
    }

    return $.ajax({
        // 渡したいurl
        url: url,
        // HttpMethod(get,post...)
        type: method,
        // サーバーから返却されるデータの型(jsonなど。何も返さなければ空文字で良い)
        dataType: data_type,
        // サーバーに送信する値(php側では連想配列のキー名として取得できる)
        data: {
            'target_data': data,
        },
    });
}
