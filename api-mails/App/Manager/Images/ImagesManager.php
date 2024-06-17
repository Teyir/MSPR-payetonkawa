<?php

namespace Mails\Manager\Images;


use Mails\Manager\Class\AbstractManager;

class ImagesManager extends AbstractManager
{
    protected static string $returnIconName;
    private static array $allowedIconTypes = [
        'image/png' => 'png',
        'image/jpg' => 'jpg',
        'image/jpeg' => 'jpeg',
        'image/gif' => 'gif',
        'image/webp' => 'webp',
        'image/x-icon' => 'ico',
        'image/x-tga' => 'ico',
        'image/svg+xml' => 'svg',
        'image/heic' => 'heic',
        'image/heif' => 'heif',
    ];

    public function upload(array $file): string
    {
        $path = "Public/Images/";

        $filePath = $file['tmp_name'];
        $fileSize = filesize($filePath);
        $fileSize2 = @getimagesize($filePath);
        $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
        $fileType = finfo_file($fileInfo, $filePath);


        $maxFileSize = self::getUploadMaxSizeFileSize();


        if (empty($fileSize2) || ($fileSize2[0] === 0) || ($fileSize2[1] === 0 || filesize($filePath) <= 0)) {
            return "ERROR_EMPTY_FILE";
        }

        if ($fileSize > $maxFileSize) {
            return "ERROR_FILE_TOO_LARGE";
        }

        if (!array_key_exists($fileType, self::$allowedIconTypes)) {
            return "ERROR_FILE_NOT_ALLOWED";
        }


        $fileName = self::genId(random_int(15, 35));


        $extension = self::$allowedIconTypes[$fileType];

        self::$returnIconName = $fileName . "." . $extension;

        $newFilePath = $path . self::$returnIconName;


        if (!copy($filePath, $newFilePath)) {
            return "ERROR_CANT_MOVE_FILE";
        }

        //Clear image metadata
        $oldFilePath = $path . $fileName . "-old." . $extension;
        self::clearMetadata($oldFilePath, $path . self::$returnIconName);

        //Return the file name with extension
        return self::$returnIconName;
    }

    /**
     * @return int
     * @desc Return in byte the uploadMaxSizeFileSize value in php.ini
     */
    private static function getUploadMaxSizeFileSize(): int
    {
        $value = ini_get('upload_max_filesize');

        if (is_numeric($value)) {
            return $value;
        }

        $valueLength = strlen($value);
        $qty = substr($value, 0, $valueLength - 1);
        $unit = strtolower(substr($value, $valueLength - 1));
        $qty *= match ($unit) {
            'k' => 1024,
            'm' => 1048576,
            'g' => 1073741824,
        };
        return $qty;
    }

    /**
     * @param int $l
     * @return string
     * @desc Return a string ID
     */
    private static function genId(int $l = 5): string
    {
        return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 10, $l);
    }

    /**
     * @param string $oldFilePath
     * @param string $filePath
     * @return void
     * @Desc Clear all the image metadata
     */
    private static function clearMetadata(string $oldFilePath, string $filePath): void
    {
        //We copy the current file
        copy($filePath, $oldFilePath);

        $bufferLen = filesize($filePath);
        $fdIn = fopen($oldFilePath, 'rb');
        $fdOut = fopen($filePath, 'wb');

        while (($buffer = fread($fdIn, $bufferLen))) {
            //  \xFF\xE1\xHH\xLLExif\x00\x00 - Exif
            //  \xFF\xE1\xHH\xLLhttp://      - XMP
            //  \xFF\xE2\xHH\xLLICC_PROFILE  - ICC
            //  \xFF\xED\xHH\xLLPhotoshop    - PH
            while (preg_match('/\xFF[\xE1\xE2\xED\xEE](.)(.)(exif|photoshop|http:|icc_profile|adobe)/si', $buffer, $match, PREG_OFFSET_CAPTURE)) {
                $len = ord($match[1][0]) * 256 + ord($match[2][0]);

                fwrite($fdOut, substr($buffer, 0, $match[0][1]));
                $filepos = $match[0][1] + 2 + $len - strlen($buffer);
                fseek($fdIn, $filepos, SEEK_CUR);


                $buffer = fread($fdIn, $bufferLen);
            }
            fwrite($fdOut, $buffer, strlen($buffer));
        }
        fclose($fdOut);
        fclose($fdIn);

        //We delete the "old" file
        unlink($oldFilePath);
    }
}