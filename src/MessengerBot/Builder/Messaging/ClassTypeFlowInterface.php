<?php

namespace Crazymeeks\MessengerBot\Builder\Messaging;

use Crazymeeks\MessengerBot\Builder\FlowBuilder;
use Crazymeeks\MessengerBot\Builder\Messaging\MessagingInterface;

interface ClassTypeFlowInterface
{


    public function getResponse(FlowBuilder $flowBuilder, MessagingInterface $message): array;
}