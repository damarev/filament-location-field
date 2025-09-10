<?php

namespace Damarev\FilamentLocationField\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Damarev\FilamentLocationField\FilamentLocationField
 */
class FilamentLocationField extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Damarev\FilamentLocationField\FilamentLocationField::class;
    }
}
