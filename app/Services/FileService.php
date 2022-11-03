<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileService
{
    /**
     * 投稿で送信された画像ファイルをpublic/uploadsフォルダに保存し、ファイル名を返します。
     *
     * @param string $user_id
     * @param UploadedFile $img_file
     * @return string $uplead_file_name
     */
    public function uploadPostImg($user_id, UploadedFile $img_file)
    {
        if(!(User::where('user_id', $user_id)->first()))
        {
            throw new NotFoundHttpException('該当のユーザーが見つかりませんでした。'.$user_id);
        }

        if(!$img_file)
        {
            logs()->error('ファイルが見つかりませんでした。');
            return;
        }

        // public/uploads配下にuser_id名のディレクトリを作成して保存。
        $file_name = $img_file->getClientOriginalName();
        $upload_file_name = time().$file_name;

        // NOTE：user_idは被らないはず？
        $target_path = public_path('uploads/'.$user_id);

        $img_file->move($target_path, $upload_file_name);

        return $upload_file_name;
    }
}
