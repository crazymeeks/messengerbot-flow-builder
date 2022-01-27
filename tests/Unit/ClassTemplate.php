<?php

namespace Tests\Unit;

use Crazymeeks\MessengerBot\Builder\FlowBuilder;
use Crazymeeks\MessengerBot\Builder\Messaging\MessagingInterface;

class ClassTemplate
{


    public function getResponse(FlowBuilder $flowBuilder, MessagingInterface $message)
    {
        // vd($flowBuilder->getPostBackPayload());
        // vd($message->getUserFacebookFirstName());

        return [
            'message' => [
                'text' => 'Hello from sample class'
            ]
        ];
    }
}