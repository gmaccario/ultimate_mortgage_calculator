<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;
use UMC\General\Classes\Common;
use UMC\Controller\Classes\Backend;

require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

/**
 * Import WordPress Core
 */
define('WP_USE_THEMES', false);
global $wp, $wp_query, $wp_the_query, $wp_rewrite, $wp_did_header;
require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR. 'wp-load.php';

final class CommonTest extends TestCase
{
    /**
     * prepare Tests
     */
    public function testPrepare(): void
    {
        $common = new Common();
        
        $this->assertTrue($common->prepare());
    }
    
    /**
     * getConfig Tests
     */
    public function testGetConfig(): void
    {
        $common = new Common();
        $common->prepare();

        $this->assertArrayHasKey('settings', $common->getConfig());
    }
    
    /**
     * printMyLastQuery Tests
     */
    public function testPrintMyLastQuery(): void
    {
        $common = new Common();
        $common->prepare();

        $this->assertNotEmpty($common->printMyLastQuery());
    }
    
    /**
     * testCheckDependencies Tests
     */
    public function testCheckDependencies(): void
    {
        $common = new Common();
        $common->prepare();
        
        $this->assertEquals(true, $common->checkDependencies());
    }
    
    /**
     * testRenderView Tests
     */
    public function testRenderView(): void
    {
        $common = new Common();
        $common->prepare();
        
        $controller = new Backend($common);
        
        $actual = $common->renderView($controller, 'no-template', array());
        
        $this->assertNull($actual);
    }
    
    /**
     * getNameClass Tests
     */
    public function testGetNameClass(): void
    {
        $common = new Common();
        
        $controller = new Backend($common);
        
        $actual = $common->getNameClass($controller);
        
        $this->assertEquals('Backend', $actual);
    }
    
    /**
     * testGetConstant Tests
     */
    public function testGetConstant(): void
    {
        $common = new Common();

        $actual = $common->getConstant('');
        
        $this->assertEquals('', $actual);
    }
    
    /**
     * testErrorNoticeDependency Tests
     */
    public function testErrorNoticeDependency(): void
    {
        $common = new Common();
        
        $actual = $common->errorNoticeDependency();
        
        $this->assertNull($actual);
    }
}