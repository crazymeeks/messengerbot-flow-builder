<?php

namespace Crazymeeks\MessengerBot\Builder\Messaging;

use Ixudra\Curl\CurlService;
use Crazymeeks\MessengerBot\Builder\FlowBuilder;
use Crazymeeks\MessengerBot\Profile\FacebookProfile;
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
        if ($_SERVER['APP_ENV'] != 'testing' && $fbToken = $this->flowBuilder->getFacebookToken()) {
            $facebookProfile = new FacebookProfile(new CurlService());
            $facebookProfile->setToken($fbToken)
                            ->setUserFacebookId($this->flowBuilder->getRecipientId())
                            ->fields(['first_name', 'last_name', 'picture'])
                            ->get();
            $name = $facebookProfile->first_name;
        } else {
            if (function_exists('get_default_fb_name')) {
                $name = \get_default_fb_name();
            }
        }

        return $name;
    }

    /**
     * @inheritDoc
     */
    public function createResponseArray(array $markUp)
    {
        $composer = new Composer($markUp);


        if (isset($markUp['next']) && $markUp['next']) {
            $this->flowBuilder->setNextFlow($markUp['next']);
        }

        return $composer->compose($this->flowBuilder);
    }
}