<?php
declare(strict_types = 1);

use PHPUnit\Framework\TestCase;
use DVNWPF\General\Classes\Common;
use DVNWPF\Controller\Classes\Controller;

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * Import WordPress Core
 */
define('WP_USE_THEMES', false);
global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'wp-load.php';

final class ControllerTest extends TestCase
{

    /**
     * GetCommon Tests
     */
    public function testGetCommon(): void
    {
        $common = new Common();

        $controller = new Controller($common);

        $this->assertInstanceOf('\DVNWPF\General\Classes\Common', $controller->getCommon());
    }

    /**
     * RenderTemplate Tests
     */
    public function testRenderTemplate(): void
    {
        $common = new Common();

        $controller = new Controller($common);
        
        $this->expectException(Exception::class);
        
        $controller->renderTemplate($controller);
    }
}