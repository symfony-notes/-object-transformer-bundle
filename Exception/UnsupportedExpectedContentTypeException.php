<?php

declare(strict_types=1);

namespace SymfonyNotes\ObjectTransformerBundle\Exception;

/**
 * Class UnsupportedExpectedContentTypeException.
 */
class UnsupportedExpectedContentTypeException extends \Exception
{
    /**
     * @var string
     */
    private $contentType;

    /**
     * @param string $contentType
     */
    public function __construct(string $contentType)
    {
        parent::__construct(sprintf(
            'Unsupported expected content type "%s"',
            $contentType
        ));

        $this->contentType = $contentType;
    }

    /**
     * @return string
     */
    public function getContentType(): string
    {
        return $this->contentType;
    }
}
