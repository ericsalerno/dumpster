<?php
/**
 * Dump an object out to a self-contained HTML document.
 *
 * @package Dumpster
 * @author Eric
 */
namespace Dumpster;

class Dump
{
    /**
     * @var \Mustache_Engine
     */
    private $mustache;

    /**
     * @var ObjectDefinition
     */
    private $contextObject;

    /**
     * @var bool
     */
    private $proceed = true;

    /**
     * Dump constructor.
     * @param $contextObject
     * @param $objectName
     *
     * @return $this
     */
    public function __construct($contextObject, $objectName = 'Debug Object')
    {
        $suppression = getenv('DUMPSTER_SUPPRESS');
        if (!empty($suppression)) $this->proceed = false;

        if (empty($this->proceed))
        {
            return $this;
        }

        if (class_exists('\Mustache_Engine'))
        {
            $this->mustache = new \Mustache_Engine([
                'loader' => new \Mustache_Loader_FilesystemLoader(__DIR__ . '/../resources/templates'),
                'partials_loader' => new \Mustache_Loader_FilesystemLoader(__DIR__ . '/../resources/templates/partials')
            ]);
        }

        $this->contextObject = new ObjectDefinition($objectName, $contextObject, 0);

        return $this;
    }

    /**
     * Output the dump contents
     */
    public function output()
    {
        if (empty($this->proceed))
        {
            return;
        }

        echo $this->buildOutput();

        die();
    }

    /**
     * Retrieve the dump contents
     *
     * @return string
     */
    public function getOutput()
    {
        if (empty($this->proceed))
        {
            return 'Dump Output Suppressed';
        }

        return $this->buildOutput();
    }

    /**
     * Build the output string
     *
     * @return string
     */
    private function buildOutput()
    {
        if (!empty($this->mustache))
        {
            $output = $this->mustache->render('dump.mustache', $this->contextObject);
        }
        else
        {
            $output = 'Some text representation when mustache is not available.';
        }

        return $output;
    }
}
