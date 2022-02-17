<?php

namespace Crazymeeks\MessengerBot\Profile;

use stdClass;

class RetrievedProfile
{

    protected $props = [];

    /**
     * Constructore
     *
     * @param \stdClass|\Crazymeeks\MessengerBot\Profile\FacebookProfile $facebookProfile
     */
    public function __construct($facebookProfile)
    {
        $this->first_name = $facebookProfile->first_name;
        $this->last_name = $facebookProfile->last_name;
        $this->picture = $facebookProfile->profile_pic;
    }

    /**
     * @inheritDoc
     */
    public function __set($name, $value)
    {
        $this->props[$name] = $value;
    }

    /**
     * @inheritDoc
     */
    public function __get($name)
    {

        if (array_key_exists($name, $this->props)) {
            return $this->props[$name];
        }

        $trace = debug_backtrace();

        @trigger_error(
            'Undefined property via __get(): ' . $name .
            ' in ' . $trace[0]['file'] .
            ' on line ' . $trace[0]['line'],
            E_USER_NOTICE);

        return null;
    }
}