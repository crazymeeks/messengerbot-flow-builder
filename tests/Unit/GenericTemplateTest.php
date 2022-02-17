<?php

namespace Tests\Unit;

use Tests\TestCase;

class GenericTemplateTest extends TestCase
{

    public function testGenericTemplateStructure()
    {
        
        $markupArray = $this->getMarkup('generictemplate');
        
        $transformed = $this->builder
                            ->setFacebookToken('fbtoken')
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
                        'template_type' => 'generic',
                        'elements' => [
                            [
                                'title' => 'Welcome!',
                                'image_url' => 'https://raw.githubusercontent.com/fbsamples/original-coast-clothing/main/public/styles/male-work.jpg',
                                'subtitle' => 'We have the right hat for everyone.',
                                'default_action' => [
                                    'type' => 'web_url',
                                    'url' => 'https://www.originalcoastclothing.com/',
                                    'webview_height_ratio' => 'tall'
                                ],
                                'buttons' => [
                                    [
                                        'type' => 'web_url',
                                        'url' => 'https://www.originalcoastclothing.com/',
                                        'title' => 'View website!'
                                    ],
                                    [
                                        'type' => 'web_url',
                                        'url' => 'https://www.originalcoastclothing.com/',
                                        'title' => 'View website 2!'
                                    ]
                                ]
                            ]
                        ]
                    ]
                ]
            ],
            'message_type' => 'RESPONSE'
        ]], $transformed);
    }

}