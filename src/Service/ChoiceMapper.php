<?php

declare(strict_types=1);

namespace App\Service;

use function array_combine;
use function array_map;
use function strtolower;

/**
 * Class ChoiceMapper
 */
final class ChoiceMapper
{
    /**
     * @param string $prefix
     * @param array  $values
     *
     * @return array
     */
    public function map(string $prefix, array $values): array
    {
        return array_combine(
            array_map(
                static function (string $value) use ($prefix) {
                    return strtolower("{$prefix}{$value}");
                },
                $values
            ),
            $values
        );
    }
}
