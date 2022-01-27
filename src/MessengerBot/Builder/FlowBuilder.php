<?php

namespace Crazymeeks\MessengerBot\Builder;

use stdClass;
use Crazymeeks\MessengerBot\Builder\MessagingFactory;

class FlowBuilder
{

    /**
     * Messenger user id
     *
     * @var string
     */
    protected $recipientId;

    /**
     * The loaded markup from xml
     *
     * @var string
     */
    protected $loadedMarkup;

    /**
     * @var \stdClass
     */
    protected $postbackPayload;


    /**
     * Set recipient id of messenger user
     *
     * This is the person where we send the response
     * 
     * @param string $recipientId
     * 
     * @return $this
     */
    public function setRecipientId(string $recipientId)
    {
        $this->recipientId = $recipientId;

        return $this;
    }

    /**
     * Set postback payload
     *
     * @param \stdClass $payload
     * 
     * @return $this
     */
    public function setPostBackPayload(stdClass $payload)
    {
        $this->postbackPayload = $payload;

        return $this;
    }

    /**
     * Get postback payload
     *
     * @return \stdClass
     */
    public function getPostBackPayload()
    {
        return $this->postbackPayload;
    }

    /**
     * Get messenger user id
     *
     * @return string
     */
    public function getRecipientId()
    {
        return $this->recipientId;
    }

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

        $message = MessagingFactory::createFromMarkup($markup, $this, $facebookProfile);

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