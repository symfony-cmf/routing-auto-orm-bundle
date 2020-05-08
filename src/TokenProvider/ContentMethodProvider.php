<?php

namespace Symfony\Cmf\Bundle\RoutingAutoOrmBundle\TokenProvider;

use Symfony\Cmf\Bundle\CoreBundle\Translatable\TranslatableInterface;
use Symfony\Cmf\Component\RoutingAuto\TokenProvider\ContentMethodProvider as BaseContentMethodProvider;
use Symfony\Cmf\Component\RoutingAuto\UriContext;

class ContentMethodProvider extends BaseContentMethodProvider
{
    /**
     * {@inheritdoc}
     */
    public function provideValue(UriContext $uriContext, $options)
    {
        $object = $uriContext->getSubject();
        $method = $options['method'];
        $this->checkMethodExists($object, $method);

        $value = $this->getValue($object, $uriContext->getLocale(), $method);

        return $this->normalizeValue($value, $uriContext, $options);
    }

    private function getValue(object $object, ?string $uriContextLocale, $method): string
    {
        if ($object instanceof TranslatableInterface) {
            $currentLocale = $object->getCurrentLocale();
            $object->setCurrentLocale($uriContextLocale);
            $value = $object->$method();
            $object->setCurrentLocale($currentLocale);

            return $value;
        }

        return $object->$method();
    }
}
