<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle\Transformer;

use SymfonyNotes\ObjectTransformerBundle\Context\ContextInterface;
use SymfonyNotes\ObjectTransformerBundle\Exception\UnsupportedTransformationException;

/**
 * Handles transformation of collection of objects.
 */
class CollectionObjectTransformer implements ObjectTransformerInterface
{
    /**
     * @var ObjectTransformer
     */
    private $objectTransformer;

    /**
     * @param ObjectTransformer $objectTransformer
     */
    public function __construct(ObjectTransformer $objectTransformer)
    {
        $this->objectTransformer = $objectTransformer;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($object, $targetClass, ContextInterface $context = null): bool
    {
        if (is_array($object) || $object instanceof \Traversable) {
            foreach ($object as $element) {
                if (!$this->objectTransformer->supports($element, $targetClass, $context)) {
                    return false;
                }
            }

            return true;
        }

        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function transform($object, $targetClass, ContextInterface $context = null)
    {
        if (count($object) === 0) {
            return [];
        }

        if (!$this->supports($object, $targetClass, $context)) {
            $objectType = is_object($object) ? get_class($object) : gettype($object);

            throw new UnsupportedTransformationException($objectType, $targetClass);
        }

        $elements = [];

        foreach ($object as $element) {
            $elements[] = $this->objectTransformer->transform($element, $targetClass, $context);
        }

        return $elements;
    }
}
