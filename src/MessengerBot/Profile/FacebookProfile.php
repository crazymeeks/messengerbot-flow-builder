<?php

namespace Crazymeeks\MessengerBot\Profile;

use stdClass;
use Ixudra\Curl\CurlService;

class FacebookProfile
{

    /**
     * Location of overloaded properties
     * 
     * @var array
     */
    protected $props = [];

    /**
     * Facebook graph uri
     *
     * @var string
     */
    private $graph_uri = 'https://graph.facebook.com';

    /**
     * Facebook graph version
     *
     * @var string
     */
    private $graph_version = 'v7.0';

    /**
     * @var \Ixudra\Curl\CurlService
     */
    protected $curl;

    /**
     * @var string
     */
    protected $token;

    /**
     * @var string
     */
    protected $userFacebookId;

    /**
     * @var string
     */
    protected $requestedFields;

    public function __construct(CurlService $curl)
    {
        $this->curl = $curl;
    }

    /**
     * Set facebook token
     *
     * @param string $token
     * 
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;
        return $this;
    }

    /**
     * Set Facebook graph version
     *
     * @param string $version
     * 
     * @return $this
     */
    public function setGraphVersion(string $version)
    {
        $this->graph_version = $version;
        return $this;
    }

    /**
     * Set user facebook id
     *
     * @param string $userFacebookId
     * 
     * @return $this
     */
    public function setUserFacebookId(string $userFacebookId)
    {
        $this->userFacebookId = $userFacebookId;
        return $this;
    }

    /**
     * The requested user profile fields allowed by facebook
     * or in requested permission
     * 
     * @param array $fields
     *
     * @return $this
     */
    public function fields(array $fields)
    {
        $this->requestedFields = implode(',', $fields);
        return $this;
    }

    /**
     * Get facebook token
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Get user facebook id
     *
     * @return string
     */
    public function getUserFacebookId()
    {
        return $this->userFacebookId;
    }

    /**
     * Get request fields
     *
     * @return string
     */
    public function getFields()
    {
        return $this->requestedFields;
    }

    /**
     * Get facebook graph version
     *
     * @return string
     */
    public function getGraphVersion()
    {
        return $this->graph_version;
    }

    /**
     * Get user profile
     *
     * @return $this
     */
    public function get()
    {
        
        $primary_token = $this->getToken();
        $response = $this->curl->to($this->graph_uri . '/' . $this->getGraphVersion() . '/' . $this->getUserFacebookId())
                               ->withHeader('Authorization: Bearer ' . $primary_token)
                               ->withData([
                                   'qs' => [
                                       'access_token' => $primary_token,
                                       'fields' => $this->getFields()
                                   ]
                               ])
                               ->withResponseHeaders()
                               ->returnResponseObject()
                               ->get();

        if (!in_array($response->status, [200, 201])) {
            $this->mapToProps(json_decode(json_encode([
                'first_name' => 'There'
            ]), true));
        } else {
            $this->mapToProps(json_decode($response->content, true));
        }
        return $this;
    }

    /**
     * Dynamically maps properties
     *
     * @param array $props
     * 
     * @return void
     */
    protected function mapToProps(array $props)
    {
        foreach($props as $field => $value){
            $this->{$field} = $value;
        }
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