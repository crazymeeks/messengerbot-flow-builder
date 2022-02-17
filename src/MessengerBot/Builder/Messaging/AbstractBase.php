<?php

namespace Crazymeeks\MessengerBot\Builder\Messaging;

use stdClass;
use Ixudra\Curl\CurlService;
use Crazymeeks\MessengerBot\Builder\FlowBuilder;
use Crazymeeks\MessengerBot\Profile\FacebookProfile;
use Crazymeeks\MessengerBot\Profile\RetrievedProfile;
use Crazymeeks\MessengerBot\Builder\Composer\Composer;
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
        $retrievedProfile = $this->retrieveUserFacebookProfile();
        return $retrievedProfile->first_name;
    }

    /**
     * Retrieve real facebook user profile info
     *
     * @return \Crazymeeks\MessengerBot\Profile\RetrievedProfile
     */
    protected function retrieveUserFacebookProfile()
    {
        $name = 'There';
        if ($_SERVER['APP_ENV'] != 'testing' && $fbToken = $this->flowBuilder->getFacebookToken()) {
            $facebookProfile = new FacebookProfile(new CurlService());
            $facebookProfile->setToken($fbToken)
                            ->setUserFacebookId($this->flowBuilder->getRecipientId())
                            ->fields(['first_name', 'last_name', 'picture'])
                            ->get();
            $retrievedProfile = new RetrievedProfile($facebookProfile);
            $this->flowBuilder->setRetrievedFacebookProfileInfo($retrievedProfile);
        } else {
            if (function_exists('get_default_fb_name')) {
                $name = \get_default_fb_name();
            }
            $stdClass = new stdClass();
            $stdClass->first_name = $name;
            $stdClass->last_name = null;
            $stdClass->picture = null;

            $retrievedProfile = new RetrievedProfile($stdClass);
            $this->flowBuilder->setRetrievedFacebookProfileInfo($retrievedProfile);
        }

        return $retrievedProfile;

    }

    /**
     * @inheritDoc
     */
    public function createResponseArray(array $markUp)
    {
        $composer = new Composer($markUp);

        $this->retrieveUserFacebookProfile();

        if (isset($markUp['next']) && $markUp['next']) {
            $this->flowBuilder->setNextFlow($markUp['next']);
        }

        return $composer->compose($this->flowBuilder);
    }
}