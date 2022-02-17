<?php

namespace Tests\Unit;

use Tests\TestCase;

class ClassTemplateTest extends TestCase
{

    public function testStructureFromClass()
    {
        
        $markupArray = $this->getMarkup('classtemplate');
        
        $transformed = $this->builder
                            ->setFacebookToken('fbtoken')
                            ->setPostBackPayload(json_decode(json_encode([
                                'action' => 'get_started',
                                'user_reply' => 'Sample user reply',
                                'title' => null,
                                'text' => 'Sample user reply',
                            ])))
                            ->setRecipientId('1234567890')
                            ->transform($markupArray['get_started']['bot']);
        
        $this->assertSame([
            [
                'recipient' => [
                    'id' => '1234567890'
                ],
                'message' => [
                    'text' => 'Hello from sample class'
                ]
            ],
            [
                'recipient' => [
                    'id' => '1234567890'
                ],
                'message' => [
                    'text' => 'Hello from sample class'
                ]
            ],
    ], $transformed);
    }

}