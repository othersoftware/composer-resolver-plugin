<?php

namespace OtherSoftware\Resolver;


final class Utilities
{
    public static function base(string ...$path): string
    {
        return self::join(dirname(__DIR__), ...$path);
    }


    public static function join(string ...$path): string
    {
        return self::normalize(join(DIRECTORY_SEPARATOR, $path));
    }


    public static function normalize(string $path): string
    {
        return str_replace('/', DIRECTORY_SEPARATOR, preg_replace('/\/+/', '/', str_replace(['/', '\\'], '/', $path)));
    }
}
