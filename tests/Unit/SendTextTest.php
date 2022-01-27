<?php

namespace Tests\Unit;

use Tests\TestCase;

class SendTextTest extends TestCase
{

    public function testSimpleTextMessageStructure()
    {
        $markupArray = $this->getMarkup('sendingtext');
        
        $transformed = $this->builder
                            ->setRecipientId('1234567890')
                            ->transform($markupArray['get_started']['bot']);
        
        $this->assertSame([
            'recipient' => [
                'id' => '1234567890'
            ],
            'message' => [
                'text' => 'Hello World There!'
            ],
            'message_type' => 'RESPONSE'
        ], $transformed);
    }

    public function testSendTextWithAttachment()
    {
        $markupArray = $this->getMarkup('sendingtextwithattachment');
        
        $transformed = $this->builder
                            ->setRecipientId('1234567890')
                            ->transform($markupArray['get_started']['bot']);
        
        $this->assertSame([
            'recipient' => [
                'id' => '1234567890'
            ],
            'message' => [
                'attachment' => [
                    'type' => 'image',
                    'payload' => [
                        'url' => 'http://www.messenger-rocks.com/image.jpg',
                        'is_reusable' => 'true'
                    ]
                ]
            ],
            'message_type' => 'RESPONSE'
        ], $transformed);
    }
}