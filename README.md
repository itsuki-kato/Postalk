## 環境構成
■フロント：  
・Laravel9から導入されたviteを使用してjsのコンパイルを行う。  
-使用要件 ⇒ _Node.js(ver.16以上)、php(ver.8)以上_。  
-LaravelMixは使用しない。  
・jsライブラリは _Vue.js_ とする。(ver.3.2.40)  
・cssはBootstrapと自作したCSSファイルを使用する。  

■サーバーサイド：  
・ライブラリの導入予定はなし。必要になったら随時追加。  


## 環境構築手順
■目標  
・フロントに.vueファイルで記述した、コンポーネントが表示される状態。  

■前提条件  
・_php(ver.8以上)_ が使用できること。  
・_Node.js(ver.16以上)_ が使用できること。  
-npmコマンドが使用できる(環境変数を登録している)こと。  

1.プロジェクトのClone。  
2.envファイルの作成。  
-env.exampleに動作確認済の設定を記載。(環境差分ありそう。。)  
3.`$composer install`でvendorディレクトリをダウンロード。  
4.`$npm install`を実行し、package.jsonの定義を元にパッケージをインストール。  
5.`$npm run dev`でjsファイルをコンパイルする。  
6.`$php artisan serve`コマンドでビルトインサーバーを起動。  
-xxampのApacheで実行する場合はdocumentrootを「プロジェクトまでのパス/public」とするか、  
 htdocs下に配置して「プロジェクトまでのパス/public」のurlでアクセスする。  
 ex)「http://localhost:8888/Postalk/public/」  
 ＊macの場合。  

■DB接続確認方法(Modelクラス作成前)  
1.envファイルにDB名、ユーザー権限名、パスワード等を記述する。  
2.適当なテーブルにデータを入れる。  
3.`$php artisan tinker`でtinkerを起動。  
4.`$DB::table('テーブル名')->get();`で2で挿入したデータが表示されていれば接続確認完了。  
5.コマンドを抜ける際は`$q`。  
