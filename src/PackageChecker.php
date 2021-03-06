<?php

namespace SimonHamp\Ensemble;

class PackageChecker extends AbstractRemoteProcessCall
{
    const SHOW_ALL = 'all';
    const MINOR_ONLY = 'minor';
    const DIRECT = 'direct';

    protected static $composer_path;

    public static function setComposerPath($path)
    {
        static::$composer_path = $path;
    }

    public static function getComposerPath()
    {
        return static::$composer_path ?: env('ENSEMBLE_COMPOSER_PATH', realpath(__DIR__.'/../../../bin/composer'));
    }

    protected static function buildCommand($command, $flags)
    {
        $cmd = [
            static::getComposerPath(),
            $command,
            '--format=json',
        ];

        if (in_array(self::SHOW_ALL, $flags)) {
            $cmd[] = '--all';
        }

        if (in_array(self::MINOR_ONLY, $flags)) {
            $cmd[] = '--minor-only';
        }

        if (in_array(self::DIRECT, $flags)) {
            $cmd[] = '--direct';
        }

        return $cmd;
    }
}
