<?php

namespace Crazymeeks\MessengerBot\Builder\Messaging\Templates;

use Crazymeeks\MessengerBot\Builder\Messaging\AbstractBase;

class Generic extends AbstractBase
{
    
    /**
     * @inheritDoc
     */
    public function getBody()
    {
        $markUp = $this->markup;
        $elements = $markUp['message']['attachment']['payload']['elements'];
        if (!isset($elements[0])) {
            $markUp['message']['attachment']['payload']['elements'] = [$elements];
        }

        $elements = $markUp['message']['attachment']['payload']['elements'];
        // convert buttons inside of the elements to a multi-array if not
        foreach($elements as $index => $element){
            
            if (!isset($element['buttons'][$index])) {
                $markUp['message']['attachment']['payload']['elements'][$index]['buttons'] = [$element['buttons']];
            }
        }

        return $this->createResponseArray($markUp);
    }
}