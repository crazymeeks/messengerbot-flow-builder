<?php

namespace Crazymeeks\MessengerBot\Builder\Messaging\Templates;

use Crazymeeks\MessengerBot\Builder\Messaging\AbstractBase;

class Button extends AbstractBase
{
    
    /**
     * @inheritDoc
     */
    public function getBody()
    {
        $markUp = $this->markup;

        $name = $this->getUserFacebookFirstName();

        // convert buttons inside of the elements to a multi-array if not
        if (!isset($markUp['message']['attachment']['payload']['buttons'][0])) {
            $markUp['message']['attachment']['payload']['buttons'] = [$markUp['message']['attachment']['payload']['buttons']];
        }

        $markUp['message']['attachment']['payload']['text'] = findReplace($markUp['message']['attachment']['payload']['text'], 'firstname', $name);
        
        return array($this->createResponseArray($markUp));
    }
}