<?php
/**
 * Object Definition Tests
 *
 * @package Dumpster
 * @subpackage Tests
 * @author Eric
 */
namespace Dumpster\Tests;

class ObjectDefinitionTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @dataProvider dataProviderScalarCreation
     */
    public function testScalarCreation($isValidScalar, $testName, $value)
    {
        $definition = new \Dumpster\ObjectDefinition($testName, $value);

        $this->assertEquals($isValidScalar, $definition->isScalar());
    }

    /**
     * @return array
     */
    public function dataProviderScalarCreation()
    {
        return [
            [true, 'test1', 'some string'],
            [true, 'test2', 14],
            [true, 'test3', null],
            [true, 'test4', true],
            [false, 'test5', new \stdClass()],
            [false, 'test6', new \Dumpster\ObjectDefinition('subTest', null)],
            [false, 'test7', []],
            [false, 'test8', ['item1']],
            [false, 'test9', ['item1'=>true]],
        ];
    }


}