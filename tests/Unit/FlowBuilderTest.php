<?php

namespace Tests\Unit;

use Tests\TestCase;
use Crazymeeks\MessengerBot\Builder\FlowBuilder;

class FlowBuilderTest extends TestCase
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

    public function testQuickReplyStructure()
    {
        
        $markup = file_get_contents(__DIR__ . '/markup/quickreply.xml');
        $markupArray = $this->builder
                         ->decodeXMLMarkUp($markup);
        
        $transformed = $this->builder->transform($markupArray['get_started']['bot']);
        
        $this->assertSame([
            'message' => [
                'text' => 'Do you want to continue?',
                'quick_replies' => [
                    [
                        'content_type' => 'text',
                        'title' => 'Yes',
                        'payload' => json_encode(['action' => 'yes_continue'])
                    ]
                ]
            ]
        ], $transformed);
    }
}