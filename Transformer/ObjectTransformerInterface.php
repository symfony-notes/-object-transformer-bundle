<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle\Transformer;

use SymfonyNotes\ObjectTransformerBundle\Context\ContextInterface;

/**
 * Responsible for object transformation with context.
 */
interface ObjectTransformerInterface
{
    /**
     * Does transformer support transformation to target class?
     *
     * @param object|array|\Traversable $object
     * @param string                    $targetClass
     * @param ContextInterface|null     $context
     *
     * @return bool
     */
    public function supports($object, $targetClass, ContextInterface $context = null): bool;

    /**
     * Transforms object to supported class with specified context.
     *
     * @param object|array|\Traversable $object
     * @param string                    $targetClass
     * @param ContextInterface|null     $context
     *
     * @return array|object|\object[]
     */
    public function transform($object, $targetClass, ContextInterface $context = null);
}
