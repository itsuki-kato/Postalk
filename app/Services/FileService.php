<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileService
{
    /**
     * フロント側からアップロードされた画像を指定パスに保存します。
     * NOTE：formからアップロードした画像しか使用できません。
     *
     * @param UploadedFile $file
     * @param string $target_path(storage/appの下の階層から指定する)
     * @return string $upload_file_name
     */
    public function uploadImg(UploadedFile $file, $target_path)
    {
        // TODO：フロントにもなにかエラー返した方がいいか。
        // TODO：エラー時の挙動を検討。(nullでいいか？)
        if(!$file || !$target_path) { return null; }

        // NOTE：タイムスタンプを付与しない場合、同じファイル名があったら削除してから登録する必要がある
        // ファイル名が被らないようにタイムスタンプを付与。
        $file_name = $file->getClientOriginalName();
        $upload_file_name = time().$file_name;

        // strage配下の指定パスに保存(ディレクトリが存在しなかったら作成も行う)
        Storage::put($target_path, $file);

        return $upload_file_name;
    }
}
