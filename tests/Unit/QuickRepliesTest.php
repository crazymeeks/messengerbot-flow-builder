<?php

namespace Tests\Unit;

use Tests\TestCase;

class QuickRepliesTest extends TestCase
{

    public function testQuickReplyStructure()
    {
        
        $markupArray = $this->getMarkup('quickreply');
        
        $transformed = $this->builder
                            ->setRecipientId('1234567890')
                            ->transform($markupArray['get_started']['bot']);
        
        $this->assertSame([
            'recipient' => [
                'id' => '1234567890'
            ],
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