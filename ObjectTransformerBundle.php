<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use SymfonyNotes\ObjectTransformerBundle\DependencyInjection\Compiler\ObjectTransformerCompilerPass;

/**
 * Class ObjectTransformerBundle.
 */
class ObjectTransformerBundle extends Bundle
{
    /**
     * @param ContainerBuilder $container
     */
    public function build(ContainerBuilder $container)
    {
        parent::build($container);

        $container->addCompilerPass(new ObjectTransformerCompilerPass());
    }
}
