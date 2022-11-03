<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class FileService
{
    /**
     * 投稿で送信された画像ファイルをpublic/uploadsフォルダに保存します。
     *
     * @param string $user_id
     * @param UploadedFile $img_file
     * @return void
     */
    public function uploadPostImg($user_id, UploadedFile $img_file)
    {
        if(!(User::where('user_id', $user_id)->get()))
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

        // TODO：表示時に問題がありそうならファイル名を検討。同じファイル名でも登録可能でDBのファイル名と照合を取る方法を検討。
        $upload_file_name = $file_name.time();

        // NOTE：user_idは被らないはず？
        $target_path = public_path('uploads/'.$user_id);

        $img_file->move($target_path, $upload_file_name);

        return;
    }
}
