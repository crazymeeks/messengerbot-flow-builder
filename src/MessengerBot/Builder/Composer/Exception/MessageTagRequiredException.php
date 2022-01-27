<?php

namespace Crazymeeks\MessengerBot\Builder\Composer\Exception;

use Exception;

class MessageTagRequiredException extends Exception
{


    public function __construct()
    {
        parent::__construct("<tag> is required when message message_type is MESSAGE_TAG");
    }
}