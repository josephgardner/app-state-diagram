<?php

declare(strict_types=1);

namespace Koriym\AlpsStateDiagram;

use Koriym\AlpsStateDiagram\Exception\RtMissingException;
use Koriym\AlpsStateDiagram\Exception\TypeSemanticException;

final class TransDescriptor
{
    /**
     * @var string
     */
    public $id;

    /**
     * @var string
     */
    public $type;

    /**
     * @var string
     */
    public $rt;

    /**
     * @var SemanticDescriptor
     */
    public $parent;

    public function __construct(\stdClass $descriptor, SemanticDescriptor $parent)
    {
        if ($descriptor->type === 'semantic') {
            throw new TypeSemanticException($descriptor->id);
        }
        $this->id = $descriptor->id;
        $this->type = $descriptor->type;
        $pos = strpos($descriptor->rt, '#');
        if ($pos === false) {
            throw new RtMissingException($descriptor->id);
        }
        $this->rt = substr($descriptor->rt, $pos + 1);
        $this->parent = $parent;
    }
}
