<?php

namespace Crazymeeks\MessengerBot\Builder\Messaging;

use Crazymeeks\MessengerBot\Builder\Messaging\MessagingInterface;

abstract class AbstractBase implements MessagingInterface
{

    /**
     * @var mixed
     */
    protected $facebookProfile = null;

    /**
     * @var array
     */
    protected $markup;

    /**
     * Constructor
     *
     * @param mixed $facebookProfile
     * @param array $markup
     */
    public function __construct(array $markup, $facebookProfile = null)
    {
        $this->markup = $markup;
        $this->facebookProfile = $facebookProfile;
    }
}