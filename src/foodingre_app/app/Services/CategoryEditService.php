<?php

namespace App\Services;

class CategoryEditService {

    private const CATEGORY_VALIDATE_LENGTH = 255;

    // カテゴリのバリデーション
    public static function validate($validateItems)
    {
        if(is_array($validateItems)) {
            $validateFlag = false;
            foreach ($validateItems as $item) {
                if ((!strlen($item)) || (strlen($item) > self::CATEGORY_VALIDATE_LENGTH)) {
                    $validateFlag = true;
                }
            }
            return $validateFlag;
        }

        if(is_string($validateItems)) {
            $validateFlag = false;
            if ((!strlen($validateItems)) || (strlen($validateItems) > self::CATEGORY_VALIDATE_LENGTH)) {
                $validateFlag = true;
            }
            return $validateFlag;
        }

    }
}