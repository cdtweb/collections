<?php declare(strict_types=1);

namespace Cdtweb\Collection;

/**
 * MakeCollectionTrait
 *
 * @package Cdtweb\Collection
 */
trait MakeCollectionTrait
{
    /**
     * Make collection from one or more arrays.
     *
     * @param array[] $arrays
     * @return Collection
     */
    public static function make(array ...$arrays): Collection
    {
        $items = [];
        foreach ($arrays as $arr) {
            $items += $arr;
        }
        return new self($items);
    }
}
