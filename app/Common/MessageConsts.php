<?php

namespace App\Common;

class MessageConsts
{
    // 投稿関連のフロントに表示するメッセージを定義
    const ERROR_POST_TITLE_REQUIRED = 'タイトルを入力してください。';
    const ERROR_POST_TEXT_REQUIRED = '本文を入力してください。';
    const ERROR_POST_IMG_FILE_TYPE = '画像ファイル以外は選択できません。';
    const ERROR_POST_IMG_LENGTH = 'ファイル名は100文字までです。';
    const ERROR_POST_SAVE = '入力内容に誤りがあるため保存できませんでした。';
    const POST_CREATE_COMPLETE = '投稿の新規作成が完了しました。';
    const POST_EDIT_COMPLETE = '投稿の編集が完了しました。';

    // マイページ関連のフロントに表示するメッセージを定義
    const USER_CATEGORY_UPDATE_COMPLETE = 'マイカテゴリの更新が完了しました。';
    const ERROR_USER_CATEGORY_EMPTY = 'カテゴリを1つ以上選択してください';
}
