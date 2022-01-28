<?php

namespace Tests\Unit;

use Tests\TestCase;

class ButtonTemplateTest extends TestCase
{

    public function testButtonTemplateStructure()
    {
        
        $markupArray = $this->getMarkup('buttontemplate');
        
        $transformed = $this->builder
                            ->setRecipientId('1234567890')
                            ->transform($markupArray['get_started']['bot']);
        $this->assertSame([[
            'recipient' => [
                'id' => '1234567890'
            ],
            'message' => [
                'attachment' => [
                    'type' => 'template',
                    'payload' => [
                        'template_type' => 'button',
                        'text' => 'What do you want to do next There?',
                        'buttons' => [
                            [
                                'type' => 'web_url',
                                'url' => 'https://www.messenger.com',
                                'title' => 'Visit Messenger'
                            ]
                        ]
                    ]
                ]
            ],
            'message_type' => 'RESPONSE'
        ]], $transformed);
    }

}