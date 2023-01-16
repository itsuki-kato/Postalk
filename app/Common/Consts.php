<?php

namespace App\Common;

class Consts
{

  // ディスク
  const DISK_DEFAULT = 'public';

  // ディレクトリ
  const DIR_PF_IMG = 'Image/pf_img'; //プロフィール画像
  const DIR_BG_IMG = 'Image/bg_img'; //背景画像


  // ユーザー情報
  const SEX_UNKONWN = 0; // 性別:不明
  const SEX_MAN     = 1; // 性別:男性
  const SEX_WOMAN   = 2; // 性別:女性

  const SEX_LIST = [
    self::SEX_UNKONWN => '教えない',
    self::SEX_MAN     => '男性',
    self::SEX_WOMAN   => '女性'
  ];

  // 検索タイプ
  const SEARCH_TYPE_USER = 0; // タイプ：ユーザー検索
  const SEARCH_TYPE_POST = 1; // タイプ：投稿検索

  const SEARCH_TYPE_LIST = [
    self::SEARCH_TYPE_USER => 'ユーザー検索',
    self::SEARCH_TYPE_POST => '投稿検索',
  ];

  // DM申請状況
  const DM_APPLY_STATUS_UNAPPLIED = 0; // 未申請
  const DM_APPLY_STATUS_APPLYING  = 1; // 申請中
  const DM_APPLY_STATUS_APPROVAL  = 2; // 承認済み
  const DM_APPLY_STATUS_DENY      = 3; // 否認
}
