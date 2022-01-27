<?php

namespace Crazymeeks\MessengerBot\Builder\Messaging;

interface MessagingInterface
{


    /**
     * Get message body
     *
     * @return array
     */
    public function getBody();

    /**
     * Get first name of facebook user
     *
     * @return string
     */
    public function getUserFacebookFirstName();

    /**
     * Create a response array
     *
     * @param array $markUp
     * 
     * @return array
     */
    public function createResponseArray(array $markUp);
}