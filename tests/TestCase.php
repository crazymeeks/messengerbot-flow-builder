<?php

namespace Tests;

use PHPUnit\Framework\TestCase as BaseTestCase;
use Crazymeeks\MessengerBot\Builder\FlowBuilder;

abstract class TestCase extends BaseTestCase
{


    /**
     * @var \Crazymeeks\MessengerBot\Builder\FlowBuilder
     */
    protected $builder;

    public function setUp(): void
    {
        parent::setUp();
        $this->builder = new FlowBuilder();
    }


    public function getMarkup(string $filename)
    {
        $markup = file_get_contents(__DIR__ . '/Unit/markup/' . $filename . '.xml');
        $markupArray = $this->builder
                         ->decodeXMLMarkUp($markup);
        return $markupArray;
    }
    
    
}