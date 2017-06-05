<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle\Tests;

use SymfonyNotes\ObjectTransformerBundle\Context\ContextInterface;
use SymfonyNotes\ObjectTransformerBundle\Transformer\ObjectTransformerInterface;

/**
 * This class is only for testing needs.
 */
class SourceToTargetObjectTransformer implements ObjectTransformerInterface
{
    public function supports($object, $targetClass, ContextInterface $context = null): bool
    {
        return
            $object instanceof ObjectTransformerSourceObject
                && is_a($targetClass, ObjectTransformerTargetObject::class, true);
    }

    /**
     * {@inheritdoc}
     *
     * @param ObjectTransformerSourceObject $object
     */
    public function transform($object, $targetClass, ContextInterface $context = null)
    {
        return new ObjectTransformerTargetObject($object->pr, $context->getPayload());
    }
}
