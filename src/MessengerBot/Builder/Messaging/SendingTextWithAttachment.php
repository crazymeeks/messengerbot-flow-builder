<?php

namespace Crazymeeks\MessengerBot\Builder\Messaging;

use Crazymeeks\MessengerBot\Builder\Messaging\AbstractBase;

class SendingTextWithAttachment extends AbstractBase
{
    
    /**
     * @inheritDoc
     */
    public function getBody()
    {
        $markUp = $this->markup;
        return $this->createResponseArray($markUp);
    }
}