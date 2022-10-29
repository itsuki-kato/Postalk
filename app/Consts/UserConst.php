<?php

namespace App\Consts;

class UserConst
{
  // ユーザー情報
  const SEX_UNKONWN = 0; // 性別:不明
  const SEX_MAN     = 1; // 性別:男性
  const SEX_WOMAN   = 2; // 性別:女性

  const SEX_LIST = [
    self::SEX_UNKONWN => '教えない',
    self::SEX_MAN     => '男性',
    self::SEX_WOMAN   => '女性'
  ];

}
