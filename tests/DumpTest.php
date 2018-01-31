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
        $this->assertContains('<div class="definition">', $output);
        $this->assertContains('<div class="scalar-type">string</div>', $output);
        $this->assertContains('<div class="scalar-value">Hello</div>', $output);
    }

    /**
     * Test simple number dump
     */
    public function testSimpleNumberDump()
    {
        $dumper = new \Dumpster\Dump(15);

        $output = $dumper->getOutput();

        $this->assertContains('<head>', $output);
        $this->assertContains('<div class="definition">', $output);
        $this->assertContains('<div class="scalar-type">number</div>', $output);
        $this->assertContains('<div class="scalar-value">15</div>', $output);
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
        $this->assertContains('<div class="definition">', $output);
        $this->assertContains('<div class="array-type">array (2 items)</div>', $output);
        $this->assertContains('<div class="scalar-type">string</div>', $output);
        $this->assertContains('<div class="scalar-value">b</div>', $output);
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
        $this->assertContains('<div class="definition">', $output);
        $this->assertContains('<div class="object-type">stdClass (3 fields)</div>', $output);
        $this->assertContains('<div class="scalar-type">boolean</div>', $output);
        $this->assertContains('<div class="scalar-type">string</div>', $output);
        $this->assertContains('<div class="scalar-type">number</div>', $output);
        $this->assertContains('<div class="scalar-value">hello &amp; goodbye</div>', $output);

        $this->assertContains('</html>', $output);
    }

    /**
     * Test special object dump
     */
    public function testSpecialObjectDump()
    {
        $object = [
            new \DateTime('1/1/2018 4:30', new \DateTimeZone('America/New_York')),
            'https://www.example.com/',
            'testing@example.com',
        ];

        $dumper = new \Dumpster\Dump($object);

        $output = $dumper->getOutput();

        $this->assertContains('<head>', $output);
        $this->assertContains('</html>', $output);
        $this->assertContains('<div class="scalar-value">2018-01-01T04:30:00-05:00</div>', $output);
        $this->assertContains('<div class="scalar-value"><a href="https://www.example.com/" target="_blank">https://www.example.com/</a></div>', $output);
        $this->assertContains('<div class="scalar-value"><a href="mailto:testing@example.com">testing@example.com</a></div>', $output);
    }

}