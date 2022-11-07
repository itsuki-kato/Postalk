<?php
if (!function_exists('upload_file')) {

  /**
   * ファイルアップロード
   *
   * @param  File   $upload_file
   * @param  string $target_dir
   * @param  string $target_disk
   * @param  string $delete_file_url
   * @return string アップロードURL
  */
  function upload_file($upload_file, $target_dir, $target_disk, $delete_file_url = null)
  {
    // 画像ファイル削除
    if(!empty($delete_file_url)) {
        Storage::delete($delete_file_url);
    }

    // 画像アップロード
    $upload_file_url = $upload_file->store($target_dir, $target_disk);

    return $upload_file_url;
  }
}
