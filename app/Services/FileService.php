<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;

class FileService
{
    /**
     * 画像を指定パスに保存します。
     *
     * @param UploadedFile $file
     * @param string $target_path
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

        // 指定パスに保存
        $file->move($target_path, $upload_file_name);

        return $upload_file_name;
    }
}
