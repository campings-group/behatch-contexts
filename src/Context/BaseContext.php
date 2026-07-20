<?php

namespace Behatch\Context;

use Behat\Behat\Context\TranslatableContext;
use Behat\MinkExtension\Context\RawMinkContext;
use Behat\Transformation\Transform;

abstract class BaseContext extends RawMinkContext implements TranslatableContext
{
    use \Behatch\Html;
    use \Behatch\Asserter;

    public static function getTranslationResources(): array
    {
        return glob(__DIR__ . '/../../i18n/*.xliff') ?: [];
    }

    // Behat 4 dropped @transform docblock annotations in favour of the #[Transform] attribute.
    // One pattern per supported locale (en / fr / pt / ru) casting ordinals/numbers to int.
    #[Transform('/^(0|[1-9]\d*)(?:st|nd|rd|th)?$/')]
    #[Transform('/^(0|[1-9]\d*)(?:ier|er|e|ème)?$/')]
    #[Transform('/^(0|[1-9]\d*)º?$/')]
    #[Transform('/^(0|[1-9]\d*)(?:ой|ий|ый|ей|й)?$/')]
    public function castToInt($count)
    {
        if (intval($count) < PHP_INT_MAX) {

            return intval($count);
        }

        return $count;
    }

    protected function getMinkContext()
    {
        $context = new \Behat\MinkExtension\Context\MinkContext();
        $context->setMink($this->getMink());
        $context->setMinkParameters($this->getMinkParameters());

        return $context;
    }
}
