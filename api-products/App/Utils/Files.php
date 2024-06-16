<?php

namespace Products\Utils;

use Exception;

class Files
{
    /**
     * @param array $data
     * @param int $numberValues
     * @return array
     * @desc Return random values from array
     */
    public static function getRandomValues(array $data, int $numberValues): array
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

        $randKeys = array_rand($data, $numberValues);

        $toReturn = [];

        if (!is_array($randKeys)) {
            return [];
        }

        foreach ($randKeys as $randKey) {
            $toReturn[] = $data[$randKey];
        }

        return $toReturn;
    }

    /**
     * @param array $oldData
     * @param int $numberValues
     * @param string $targetIndex
     * @param mixed $targetIndexValue
     * @return array
     * @desc Return random values from array with a specific index
     */
    public static function getRandomValuesWithSpecificIndex(array $oldData, int $numberValues, string $targetIndex, mixed $targetIndexValue): array
    {
        $dataLength = 0;
        $data = [];
        foreach ($oldData as $item) {
            if (isset($item[$targetIndex]) && $item[$targetIndex] === $targetIndexValue) {
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

        $randKeys = array_rand($data, $numberValues);

        $toReturn = [];

        if (!is_array($randKeys)) {
            return [];
        }

        foreach ($randKeys as $randKey) {
            $toReturn[] = $data[$randKey];
        }

        return $toReturn;
    }
}