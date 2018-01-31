<?php

require_once(__DIR__ . "/../vendor/autoload.php");

class Job
{
    public $title;

    public $employerId;
}

class Person
{
    public $name;

    public $type;

    public $date;

    public $value;

    public $email;

    public $occupation;
}

$s1 = new Person();
$s1->name = "James";
$s1->date = new \DateTime();
$s1->type = "Employee";
$s1->value = "http://example.com/james";
$s1->email = "james@example.com";
$s1->occupation = new Job();
$s1->occupation->employerId = 2;
$s1->occupation->title = "Chief Strategist";

$s2 = new Person();

$s2->name = "Franz";
$s2->date = new \DateTime();
$s2->type = "Owner";
$s2->value = "http://example.com/franz";
$s2->occupation = new Job();
$s2->occupation->employerId = 2;
$s2->occupation->title = "Chief Executive Officer";

$array = [$s1, $s2];

\Dumpster\Dump::object($array);