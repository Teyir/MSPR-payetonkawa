<?php

namespace Orders\Utils;

use Orders\Manager\Env\EnvManager;
use Exception;
use JetBrains\PhpStorm\ExpectedValues;

class Tools
{
    /**
     * @param int $length
     * @return string
     */
    public static function generateRandomString(int $length): string
    {
        return substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 10, $length);
    }


    /**
     * @param int $length
     * @return string
     */
    public static function generateRandomNumber(int $length): string
    {
        return substr(str_shuffle("0123456789"), 0, $length);
    }

    /**
     * @param string $data
     * @return string
     * @desc Replace CamelCase to snake_case. Ex: blaBla => bla_bla
     */
    public static function camelCaseToSnakeCase(string $data): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $data));
    }

    /**
     * @param array $data
     * @param int $numberValues
     * @param bool $isClientPremium
     * @param string ...$premiumIndex
     * @return array
     * @desc Return random values from array. This method ignore premium contents if the client is note premium
     */
    public static function getRandomValues(array $data, int $numberValues, bool $isClientPremium, string ...$premiumIndex): array
    {
        $dataLength = count($data);

        // If the numberValues is higher than array length, we set the array length.
        if ($dataLength < $numberValues) {
            $numberValues = $dataLength;
        }

        // Prevent errors.
        if ($numberValues === 1) {
            try {
                return [$data[random_int(1, 50)]];
            } catch (Exception) {
                return [$data[0]];
            }
        }

        $toReturn = [];

        foreach ($data as $item) {
            //Foreach all premium index like 'gamemode_premium', 'theme_premium'
            foreach ($premiumIndex as $str) {
                if (!$isClientPremium && $item[$str] === 1) {
                    continue 2;
                }
            }

            $toReturn[] = $item;
        }

        return self::shuffleArray($toReturn, $numberValues);
    }

    /**
     * @param array $oldData
     * @param int $numberValues
     * @param string $targetIndex
     * @param mixed $targetIndexValue
     * @param bool $isClientPremium
     * @param string ...$premiumIndex
     * @return array
     * @desc Return random values from array with a specific index. This method ignore premium contents if the client is note premium
     */
    public static function getRandomValuesWithSpecificIndex(array $oldData, int $numberValues, string $targetIndex, mixed $targetIndexValue, bool $isClientPremium, string ...$premiumIndex): array
    {
        $dataLength = 0;
        $data = [];
        foreach ($oldData as $item) {
            if (isset($item[$targetIndex]) && $item[$targetIndex] === $targetIndexValue) {

                //Foreach all premium index like 'gamemode_premium', 'theme_premium'
                foreach ($premiumIndex as $str) {
                    if (!$isClientPremium && $item[$str] === 1) {
                        continue 2;
                    }
                }

                $data[] = $item;
                $dataLength++;
            }
        }

        // If the numberValues is higher than array length, we set the array length.
        if ($dataLength < $numberValues) {
            $numberValues = $dataLength;
        }

        // Prevent errors.
        if ($numberValues === 1) {
            try {
                return [$data[random_int(1, 50)]];
            } catch (Exception) {
                return [$data[0]];
            }
        }

        return self::shuffleArray($data, $numberValues);
    }


    /**
     * @param array $array
     * @param int $numberValues
     * @return array[]
     */
    private static function shuffleArray(array &$array, int $numberValues): array
    {
        $keys = array_keys($array);

        shuffle($keys);

        $toReturn = [];

        $index = 0;
        foreach ($keys as $key) {
            if ($index === $numberValues) {
                return [...$toReturn];
            }

            $toReturn[$key] = $array[$key];
            ++$index;
        }

        $array = $toReturn;

        return [...$toReturn];
    }

    public static function secondsToTime(int $seconds): string
    {
        $secs = $seconds % 60;
        $hrs = $seconds / 60;
        $mins = $hrs % 60;

        $hrs /= 60;

        return (int)$hrs . "h " . $mins . "m " . $secs . "s";
    }

    public static function getUrl(): string
    {
        return self::getProtocol() . "://$_SERVER[HTTP_HOST]" . EnvManager::getInstance()->getValue("PATH_SUBFOLDER");
    }

    #[ExpectedValues(values: ['https', 'http'])]
    public static function getProtocol(): string
    {
        return in_array($_SERVER['HTTPS'] ?? '', ['on', 1], true) || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? '') === 'https' ? 'https' : 'http';
    }

    public static function addIfNotNull(array &$array, mixed $value): void
    {
        if (!empty($value)) {
            $array[] = $value;
        }
    }
}