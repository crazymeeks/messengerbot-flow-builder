<?php

namespace Crazymeeks\MessengerBot\Builder\Messaging;

use Crazymeeks\MessengerBot\Builder\Messaging\AbstractBase;

class SendingText extends AbstractBase
{
    
    /**
     * @inheritDoc
     */
    public function getBody()
    {
        $markUp = $this->markup;
        $name = $this->getUserFacebookFirstName();

        $markUp['message']['text'] = findReplace($markUp['message']['text'], 'firstname', $name);
        
        return array($this->createResponseArray($markUp));
    }
}