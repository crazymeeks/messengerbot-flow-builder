<?php

namespace Tests\Unit\Profile;

use Mockery;
use Tests\TestCase;
use Ixudra\Curl\CurlService;
use Crazymeeks\MessengerBot\Profile\FacebookProfile;

class FacebookProfileTest extends TestCase
{


    /**
     * @var \Ixudra\Curl\CurlService
     */
    protected $curl;

    public function setUp(): void
    {
        parent::setUp();
        $this->curl = Mockery::mock(CurlService::class);
    }

    public function testGetUserProfile()
    {
        $this->mockSuccess();
        $facebook = new FacebookProfile($this->curl);

        $facebook->setToken('fbtoken')
                             ->setUserFacebookId('1234567890')
                             ->setGraphVersion('v12.0')
                             ->fields(['first_name', 'last_name', 'picture'])
                             ->get();

        $this->assertEquals('John', $facebook->first_name);
        $this->assertEquals('Doe', $facebook->last_name);
    }


    public function testReturnDefaultFirstNameWhenErrorHappenedRetrievingFacebookProfile()
    {
        $this->mockFailed();
        $facebook = new FacebookProfile($this->curl);

        $facebook->setToken('fbtoken')
                             ->setUserFacebookId('1234567890')
                             ->setGraphVersion('v12.0')
                             ->fields(['first_name', 'last_name', 'profile_pic'])
                             ->get();

        $this->assertEquals('There', $facebook->first_name);
        $this->assertNull($facebook->last_name);
    }

    protected function mockSuccess()
    {
        $this->curl->shouldReceive('to')
                   ->with('https://graph.facebook.com/v12.0/1234567890')
                   ->andReturnSelf();
        $this->curl->shouldReceive('withHeader')
                   ->with('Authorization: Bearer fbtoken')
                   ->andReturnSelf();
        $this->curl->shouldReceive('withData')
                   ->with([
                       'qs' => [
                           'access_token' => 'fbtoken',
                           'fields' => 'first_name,last_name,picture'
                       ]
                   ])
                   ->andReturnSelf();
        $this->curl->shouldReceive('withResponseHeaders')
                   ->andReturnSelf();
        $this->curl->shouldReceive('returnResponseObject')
                   ->andReturnSelf();
        $this->curl->shouldReceive('get')
                   ->andReturn(json_decode(json_encode([
                       'content' => json_encode([
                           'first_name' => 'John',
                           'last_name' => 'Doe',
                           'picture' => 'https://facebook.com/me/1234567890/picture.jpg'
                       ]),
                       'status' => 200,
                   ])));
    }

    protected function mockFailed()
    {
        $this->curl->shouldReceive('to')
                   ->with('https://graph.facebook.com/v12.0/1234567890')
                   ->andReturnSelf();
        $this->curl->shouldReceive('withHeader')
                   ->with('Authorization: Bearer fbtoken')
                   ->andReturnSelf();
        $this->curl->shouldReceive('withData')
                   ->with([
                       'qs' => [
                           'access_token' => 'fbtoken',
                           'fields' => 'first_name,last_name,picture'
                       ]
                   ])
                   ->andReturnSelf();
        $this->curl->shouldReceive('withResponseHeaders')
                   ->andReturnSelf();
        $this->curl->shouldReceive('returnResponseObject')
                   ->andReturnSelf();
        $this->curl->shouldReceive('get')
                   ->andReturn(json_decode(json_encode([
                       'content' => json_encode(['Error']),
                       'status' => 401,
                   ])));
    }

}