<?php

namespace Behatch\Context\ContextClass;

use Behat\Behat\Context\ContextClass\ClassResolver as BaseClassResolver;

class ClassResolver implements BaseClassResolver
{
    public function supportsClass(string $contextString): bool
    {
        return (strpos($contextString, 'behatch:context:') === 0);
    }

    public function resolveClass(string $contextString): string
    {
        $className = preg_replace_callback('/(^\w|:\w)/', function ($matches) {
            return str_replace(':', '\\', strtoupper($matches[0]));
        }, $contextString);

        return $className . 'Context';
    }
}
