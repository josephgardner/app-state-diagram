<?php

declare(strict_types=1);

namespace Koriym\AppStateDiagram;

use function basename;

final class AppStateDiagram
{
    /** @var AlpsProfile */
    private $alps;

    /** @var string */
    private $alpsFile;

    public function __construct(string $alpsFile)
    {
        $this->alps = new AlpsProfile($alpsFile);
        $this->alpsFile = basename($alpsFile);
    }

    public function getDot(): string
    {
        return (new AsdRenderer())($this->alps->links, $this->alps->descriptors);
    }

    public function getVocabulary(): Vocabulary
    {
        return new Vocabulary($this->alps->descriptors, $this->alpsFile);
    }
}
