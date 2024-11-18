<?php

namespace App\Services;

use App\Constants\UserConstants;
use Illuminate\Support\Facades\Storage;

class ImageService
{

    // 新規 / 更新時のバリデーション処理
    public static function validateImage($images)
    {
        $validateFlag = false;

        // 画像の有無確認、ない場合は処理終了
        if(is_null($images)) {
            return $validateFlag;
        }
        
        // 枚数確認 配列でファイル数チェック
        if(count($images) > UserConstants::MAX_IMAGE_NUMBERS) {
            $validateFlag = true;
            return $validateFlag;
        }

        // 一枚ごとにチェックする
        foreach($images as $image) {
            // 拡張子確認
            $mimeType = $image->getMimeType();            
            if($mimeType !== 'image/png' && $mimeType !== 'image/jpg' && $mimeType !== 'image/jpeg') {
                $validateFlag = true;
            }
            // 画像ファイルサイズ確認
            $fileSize = $image->getSize();
            if($fileSize > UserConstants::MAX_IMAGE_FILE_SIZE) {
                $validateFlag = true;
            }
        }
        return $validateFlag;
    }

    // 新規作成時のアップロード処理
    public static function upload($key, $image, $folderName)
    {
        // アップロード機能の作成から開始
        if(is_array($image)){
            $file = $image[$key];
        } else {
            $file = $image;
        }

        // 書き込みを開始する
        // 開発の場合はlocal、本番はs3とする
        $disk = (env('APP_ENV') === 'local') ? 'local' : 's3';

        $path = Storage::disk($disk)->put('public/' . $folderName, $file);
        
        // DBへ格納するファイル名を返す
        $filepath = self::filenameOutput($path, $disk);

        return $filepath;

    }

    // 更新時のキー番号、リクエスト枚数のバリデーション
    public static function requestImageNumberValidation($request)
    {
        $validateFlag = false;

        // 更新がない場合は、何もせずに返る
        if(is_null($request->images)) {
            return $validateFlag;
        }
        
        $imageNumberKeys = array_keys($request->images);

        // キー数(リクエスト数)の確認
        if(count($imageNumberKeys) > UserConstants::MAX_IMAGE_NUMBERS) {
            $validateFlag = true;
        }
        
        // キー番号の確認
        foreach ($imageNumberKeys as $key) {
            if($key > UserConstants::MAX_IMAGE_NUMBERS || $key < UserConstants::MIN_IMAGE_NUMBERS ) {
                $validateFlag = true;
            }
        }
        
        return $validateFlag;
    }

    // 更新対象と削除対象ファイルの決定 /不正なリクエスト時はfalseを返す
    public static function decideDeleteAndUpdateResult($request)
    {
        // 結果用の変数
        $result = null;

        // 更新有無と画像のリクエストの確認;
        $updateFlags = $request->updateFlag;
        $imageRequests = $request->images ?? [];

        // 画像の更新・削除・維持を決定する
        foreach($updateFlags as $key => $updateFlag) {
            $imageRequest = $imageRequests[$key] ?? null;
            // 処理をSwitchでかく
            switch($updateFlag) {
                // addの時、画像なし = 画像追加しない / 画像あり = 画像追加する
                case 'add':
                    $result[] = (is_null($imageRequest)) ? 'none' : 'add';
                    break;
                
                // updateの時、画像なし = 画像削除 / 画像あり = 画像を更新
                case 'update':
                    $result[] = (is_null($imageRequest)) ? 'delete' : 'update';
                    break;
                
                // sustainの時、いかなる場合でも画像は更新しない
                case 'sustain':
                    $result[] = 'sustain';
                    break;
                
                // その他リクエストの時は更新処理を停止する
                default:
                    $result[] = 'bad_request';
            }            
        }
        
        // $result[]の中に'bad_request'がないか確認
        if(array_search('bad_request',$result)) {
            return false;
        } else {
            return $result;
        }
    }

    // 画像ファイルの更新/削除処理とDB書き込み準備
    public static function imageFilesControl($postInfo, $images, $decideDeleteAndUpdateResults)
    {
        // 現在の画像パスを取得
        $currentImagesPaths = [
            0 => $postInfo->imageFirst->filename ?? null,
            1 => $postInfo->imageSecond->filename ?? null,
            2 => $postInfo->imageThird->filename ?? null,
            3 => $postInfo->imageFourth->filename ?? null,
        ];

        // 現在の画像IDを取得
        $currentImageIds = [
            0 => $postInfo->image_first ?? null,
            1 => $postInfo->image_second ?? null,
            2 => $postInfo->image_third ?? null,
            3 => $postInfo->image_fourth ?? null,
        ];

        // 画像の更新/削除処理
        foreach($decideDeleteAndUpdateResults as $key => $result) {
            if($result === "add") {
                $imagePath[$key] = self::upload($key ,$images[$key], 'posts');
                $deletePath[$key] = null;

            } elseif($result === "update") {
                $imagePath[$key] = self::upload($key ,$images[$key], 'posts');
                self::delete($currentImagesPaths[$key]);
                $deletePath[$key] = $currentImagesPaths[$key];

            } elseif($result === "delete") {
                $imagePath[$key] = null;
                self::delete($currentImagesPaths[$key]);
                $deletePath[$key] = $currentImagesPaths[$key];

            } elseif($result === "sustain") {
                $imagePath[$key] = null;
                $deletePath[$key] = null;

            } elseif($result === "none") {
                $imagePath[$key] = null;
                $deletePath[$key] = null;

            }
        }

        return [$imagePath, $deletePath, $currentImageIds];
    }


    public static function delete($filePath)
    {
        // 開発の場合はlocal、本番はs3とする
        $disk = (env('APP_ENV') === 'local') ? 'local' : 's3';
        $deleteFilePath = self::filenameDelete($filePath, $disk);
        Storage::delete($deleteFilePath);
    }


    // DBへ格納するファイル名の制御
    private static function filenameOutput($path, $disk)
    {
        if($disk !== "s3") {
            $filepath = str_replace("public/", "storage/", $path);
        } else {
            $filepath = $path;
        }

        return $filepath;
    }

    private static function filenameDelete($path, $disk)
    {
        if( $disk !== "s3") {
        $filepath = str_replace("storage/", "public/", $path);
        } else {
            $filepath = $path;
        }

        return $filepath;
    }

}