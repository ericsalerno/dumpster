<?php
/**
 * Dump Test
 *
 * @package Dumpster
 * @subpackage Tests
 * @author Eric
 */
namespace Dumpster\Tests;

class DumpTest extends \PHPUnit\Framework\TestCase
{
    /**
     * Test simple string dump
     */
    public function testSimpleStringDump()
    {
        $dumper = new \Dumpster\Dump("Hello");

        $output = $dumper->getOutput();

        $this->assertContains('<head>', $output);
        $this->assertContains('<div class="definition scalar">', $output);
        $this->assertContains('<div class="type">string</div>', $output);
        $this->assertContains('<div class="value">Hello</div>', $output);
    }

    /**
     * Test simple number dump
     */
    public function testSimpleNumberDump()
    {
        $dumper = new \Dumpster\Dump(15);

        $output = $dumper->getOutput();

        $this->assertContains('<head>', $output);
        $this->assertContains('<div class="definition scalar">', $output);
        $this->assertContains('<div class="type">number</div>', $output);
        $this->assertContains('<div class="value">15</div>', $output);
        $this->assertContains('</html>', $output);
    }

    /**
     * Test simple array dump
     */
    public function testSimpleArrayDump()
    {
        $dumper = new \Dumpster\Dump(['a','b']);

        $output = $dumper->getOutput();

        $this->assertContains('<head>', $output);
        $this->assertContains('<div class="definition array">', $output);
        $this->assertContains('<div class="type">array (2)</div>', $output);
        $this->assertContains('<div class="type">string</div>', $output);
        $this->assertContains('<div class="value">b</div>', $output);
        $this->assertContains('</html>', $output);
    }

    /**
     * Test a simple object dump
     */
    public function testSimpleObjectDump()
    {
        $object = new \stdClass();
        $object->a = true;
        $object->b = 'hello & goodbye';
        $object->c = 1;

        $dumper = new \Dumpster\Dump($object);

        $output = $dumper->getOutput();

        $this->assertContains('<head>', $output);
        $this->assertContains('<div class="definition object">', $output);
        $this->assertContains('<div class="type">object (3)</div>', $output);
        $this->assertContains('<div class="type">boolean</div>', $output);
        $this->assertContains('<div class="type">string</div>', $output);
        $this->assertContains('<div class="type">number</div>', $output);
        $this->assertContains('<div class="value">hello &amp; goodbye</div>', $output);

        $this->assertContains('</html>', $output);
    }

}