<?php

namespace App\Services;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Common\Consts;

class FileService
{
    /**
     * フロント側からアップロードされた画像を指定パスに保存します。
     * NOTE：formからアップロードした画像しか使用できません。
     *
     * @param UploadedFile $file
     * @param string $target_path(storage/app/publicの下の階層から指定する)
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

        // strage配下の指定パスに保存(diskはpublic)
        $file->storeAs($target_path, $upload_file_name, Consts::DISK_DEFAULT);

        return $upload_file_name;
    }
}
