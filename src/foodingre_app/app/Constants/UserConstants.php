<?php

namespace App\Constants;

class UserConstants
{
    // ユーザー用（ユーザーアクティブ）
    public const USER_AVAILABLE = 1;
    public const USER_DISABLE = 0;

    // ユーザー用（権限）
    public const NORMAL_AUTHORITY = 1;
    public const GUEST_AUTHORITY = 0;

    // ゲストユーザー用ログイン情報
    public const GUEST_NAME = 'guest';
    public const GUEST_EMAIL = 'guest@test.com';
    public const GUEST_PW = 'password';
    public const GUEST_NICKNAME = 'guest_nickname1';

    // 投稿関連
    public const MIN_IMAGE_NUMBERS = 0;
    public const MAX_IMAGE_NUMBERS = 4;
    public const MAX_IMAGE_FILE_SIZE = 2048000;

}