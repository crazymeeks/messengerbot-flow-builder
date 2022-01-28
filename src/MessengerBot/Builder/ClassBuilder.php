<?php

namespace Crazymeeks\MessengerBot\Builder;

use LogicException;
use Crazymeeks\MessengerBot\Builder\Messaging\AbstractBase;
use Crazymeeks\MessengerBot\Builder\Messaging\ClassTypeFlowInterface;

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
            if (!$instance instanceof ClassTypeFlowInterface) {
                throw new LogicException("The class $class must implement " . ClassTypeFlowInterface::class);
            }
            $response = $instance->getResponse($this->flowBuilder, $this);
            $responses[] = $this->createResponseArray($response);
        }
        
        return $responses;
    }
}