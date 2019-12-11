<?php

declare(strict_types=1);

namespace Koriym\AlpsStateDiagram;

use Koriym\AlpsStateDiagram\Exception\AlpsFileNotReadable;
use Koriym\AlpsStateDiagram\Exception\InvaliDirPath;
use PHPUnit\Framework\TestCase;

class AlpsStateDiagramTest extends TestCase
{
    /**
     * @var AlpsStateDiagram
     */
    protected $alpsStateDiagram;

    protected function setUp() : void
    {
        $this->alpsStateDiagram = new AlpsStateDiagram;
    }

    public function testIsInstanceOfAlpsStateDiagram() : void
    {
        $actual = $this->alpsStateDiagram;
        $this->assertInstanceOf(AlpsStateDiagram::class, $actual);
    }

    public function testFileNotReadable() : void
    {
        $this->expectException(AlpsFileNotReadable::class);
        ($this->alpsStateDiagram)('');
    }

    public function test__invoke() : void
    {
        $dot = ($this->alpsStateDiagram)(__DIR__ . '/Fake/alps.json');
        $this->assertStringContainsString('Index->Blog [label = "blog (safe)"];', $dot);
        $this->assertStringContainsString('Blog->BlogPosting [label = "blogPosting (safe), item (safe)"];', $dot);
        $this->assertStringContainsString('Blog->Blog [label = "post (unsafe)"];', $dot);
        $this->assertStringContainsString('Blog->About [label = "about (safe)"];', $dot);
        $this->assertStringContainsString('BlogPosting->Blog [label = "collection (safe)"];', $dot);
        $this->assertStringContainsString('Blog->About', $dot);
        file_put_contents(__DIR__ . '/alps.dot', $dot);
    }

    public function testScanDirInvalidPath()
    {
        $this->expectException(InvaliDirPath::class);
        ($this->alpsStateDiagram)->scanDir(__DIR__ . '/__INVALID__');
    }
}
