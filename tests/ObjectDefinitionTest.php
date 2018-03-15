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
        $definition = new \Dumpster\ObjectDefinition($testName, $value, 0);

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
            [false, 'test6', new \Dumpster\ObjectDefinition('subTest', null, 0)],
            [false, 'test7', []],
            [false, 'test8', ['item1']],
            [false, 'test9', ['item1'=>true]],
        ];
    }

    /**
     * @param $isValidArray
     * @param $testName
     * @param $value
     * @dataProvider dataProviderArrayCreation
     */
    public function testArrayCreation($isValidArray, $testName, $value)
    {
        $definition = new \Dumpster\ObjectDefinition($testName, $value, 0);

        $this->assertEquals($isValidArray, $definition->isArray());
    }

    /**
     * @return array
     */
    public function dataProviderArrayCreation()
    {
        return [
            [false, 'test1', 'some string'],
            [false, 'test2', 14],
            [false, 'test3', null],
            [false, 'test4', true],
            [false, 'test5', new \stdClass()],
            [false, 'test6', new \Dumpster\ObjectDefinition('subTest', null, 0)],
            [true, 'test7', []],
            [true, 'test8', ['item1']],
            [true, 'test9', ['item1'=>true]],
        ];
    }

    /**
     * @param $isValidObject
     * @param $testName
     * @param $value
     * @dataProvider dataProviderObjectCreation
     */
    public function testObjectCreation($isValidObject, $testName, $value)
    {
        $definition = new \Dumpster\ObjectDefinition($testName, $value, 0);

        $this->assertEquals($isValidObject, $definition->isObject());
    }

    /**
     * @return array
     */
    public function dataProviderObjectCreation()
    {
        return [
            [false, 'test1', 'some string'],
            [false, 'test2', 14],
            [false, 'test3', null],
            [false, 'test4', true],
            [true, 'test5', new \stdClass()],
            [true, 'test6', new \Dumpster\ObjectDefinition('subTest', null, 0)],
            [false, 'test7', []],
            [false, 'test8', ['item1']],
            [false, 'test9', ['item1'=>true]],
        ];
    }

    /**
     * Test object scoping
     */
    public function testObjectScoping()
    {
        $definition = new \Dumpster\ObjectDefinition('root', new Mocks\TestObject(), 0);

        $this->assertCount(3, $definition->getChildren());
    }
}

