<?php

namespace Crazymeeks\MessengerBot\Builder;

use stdClass;
use Crazymeeks\MessengerBot\Profile\RetrievedProfile;
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
     * <next>flow</next>
     *
     * @var string
     */
    protected $nextFlow = null;

    /**
     * @var string
     */
    protected $facebookToken = null;

    /**
     * @var \Crazymeeks\MessengerBot\Profile\RetrievedProfile
     */
    protected $retrievedProfile;

    /**
     * Set facebook token
     *
     * @param string $token
     * 
     * @return $this
     */
    public function setFacebookToken(string $token)
    {
        $this->facebookToken = $token;
        return $this;
    }

    /**
     * Get facebook token
     *
     * @return string
     */
    public function getFacebookToken()
    {
        return $this->facebookToken;
    }

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
     * Set the next flow. Next flow is <next>tag</next> in xml
     *
     * @param string $next
     * 
     * @return $this
     */
    public function setNextFlow(string $next)
    {
        $this->nextFlow = $next;
        return $this;
    }

    /**
     * Check if we have next flow
     *
     * @return boolean
     */
    public function hasNextFlow()
    {
        return !is_null($this->nextFlow);
    }

    /**
     * Get next flow
     *
     * @return string
     */
    public function getNextFlow()
    {
        return $this->nextFlow;
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

    /**
     * Set facebook user profile information
     * 
     * @param \Crazymeeks\MessengerBot\Profile\RetrievedProfile
     *
     * @return $this
     */
    public function setRetrievedFacebookProfileInfo(RetrievedProfile $profile)
    {
        $this->retrievedProfile = $profile;
        return $this;
    }

    /**
     * The retrieved facebook user profile
     *
     * @return \Crazymeeks\MessengerBot\Profile\RetrievedProfile
     */
    public function retrievedFacebookProfile()
    {
        return $this->retrievedProfile;
    }


}