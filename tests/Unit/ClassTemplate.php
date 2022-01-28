<?php

namespace Tests\Unit;

use Crazymeeks\MessengerBot\Builder\FlowBuilder;
use Crazymeeks\MessengerBot\Builder\Messaging\MessagingInterface;
use Crazymeeks\MessengerBot\Builder\Messaging\ClassTypeFlowInterface;

class ClassTemplate implements ClassTypeFlowInterface
{


    public function getResponse(FlowBuilder $flowBuilder, MessagingInterface $message): array
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