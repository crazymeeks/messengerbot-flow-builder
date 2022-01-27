<?php

namespace Crazymeeks\MessengerBot\Builder\Messaging;

use Crazymeeks\MessengerBot\Builder\FlowBuilder;
use Crazymeeks\MessengerBot\Builder\Composer\Composer;
use Crazymeeks\MessengerBot\Profile\FacebookProfileInterface;
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
     * @var \Crazymeeks\MessengerBot\Builder\FlowBuilder
     */
    protected $flowBuilder;

    /**
     * Constructor
     *
     * @param mixed $facebookProfile
     * @param array $markup
     */
    public function __construct(array $markup, FlowBuilder $flowBuilder, $facebookProfile = null)
    {
        $this->markup = $markup;
        $this->flowBuilder = $flowBuilder;
        $this->facebookProfile = $facebookProfile;
    }

    /**
     * @inheritDoc
     */
    public function getUserFacebookFirstName()
    {
        $name = 'There';
        if (function_exists('get_default_fb_name')) {
            $name = \get_default_fb_name();
        }

        if ($this->facebookProfile instanceof FacebookProfileInterface) {
            $name = $this->facebookProfile->first_name;
        }

        return $name;
    }

    /**
     * @inheritDoc
     */
    public function createResponseArray(array $markUp)
    {
        $composer = new Composer($markUp);
        return $composer->compose($this->flowBuilder);
    }
}