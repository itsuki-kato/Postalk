## 環境構成
■フロント：
・Laravel9から導入されたviteを使用してjsのコンパイルを行う。
-使用要件 ⇒ Node.js(ver.16以上)、php(ver.8)以上。
-LaravelMixは使用しない。
・jsライブラリはVue.jsとする。(ver.3.2.40)
・cssはBootstrapと自作したCSSファイルを使用する。

■サーバーサイド：
・ライブラリの導入予定はなし。必要になったら随時追加。


## 環境構築手順
■目標
・フロントに「top.vue」ファイルで記述した、"Hello World"が表示される状態。

■前提条件
・php(ver.8以上)が使用できること。
・Node.js(ver.16以上)が使用できること。
-npmコマンドが使用できる(環境変数を登録している)こと。

1.プロジェクトのClone。
2.「.env」ファイルの作成。
-「.env.example」に動作確認済の設定を記載。(環境差分ありそう。。)
3.「$composer -install」でvendorディレクトリをダウンロード。
4.「$npm run dev」でjsファイルをコンパイルする。
5.「$php artisan serve」コマンドでビルトインサーバーを起動。
-xxampのApacheで実行する場合はdocumentrootを「プロジェクトまでのパス/public」とするか、
 htdocs下に配置して「プロジェクトまでのパス/public」のurlでアクセスする。
 ex)「http://localhost:8888/Postalk/public/」＊macの場合。
