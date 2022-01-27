<?php

namespace Crazymeeks\MessengerBot\Builder;

use Crazymeeks\MessengerBot\Builder\Messaging\AbstractBase;

class ClassBuilder extends AbstractBase
{


    /**
     * @inheritDoc
     */
    public function getBody()
    {
        $markUp = $this->markup;
        $classes = $markUp['message']['class'];
        $responses = [];
        foreach($classes as $class){
            $instance = new $class();
            $response = $instance->getResponse($this->flowBuilder, $this);
            $responses[] = $this->createResponseArray($response);
        }
        
        return $responses;
    }
}