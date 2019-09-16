<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use UMC\General\Classes\Basic;

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

final class BasicTest extends TestCase
{
    /**
     * debugArray Tests
     */
    public function testBasic(): void
    {
        $basic = new Basic();

        $this->assertNull($basic->debugArray(['a','b','c']));
    }
}