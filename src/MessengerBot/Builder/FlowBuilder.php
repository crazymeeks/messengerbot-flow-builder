<?php

namespace Crazymeeks\MessengerBot\Builder;


use Crazymeeks\MessengerBot\Builder\MessagingFactory;

class FlowBuilder
{

    protected $loadedMarkup;


    /**
     * Transform markup to the format that can be accepted
     * by messenger platform
     *
     * @param array $markup
     * @param mixed $facebookProfile
     * 
     * @return mixed
     */
    public function transform(array $markup, $facebookProfile = null)
    {

        $message = MessagingFactory::createFromMarkup($markup, $facebookProfile);

        return $message->getBody();

    }

    /**
     * Decode xml markup
     * 
     * @param string $markup
     * 
     * @return array
     */
    public function decodeXMLMarkUp(string $markup)
    {
        $xml = simplexml_load_string($markup, 'SimpleXMLElement', LIBXML_NOCDATA);
        $markUpArray = json_decode(json_encode($xml), TRUE);

        return $markUpArray;
    }
}