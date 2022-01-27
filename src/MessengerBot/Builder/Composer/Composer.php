<?php


/*
 * Message composer class.
 * 
 * This is responsible for transforming final response
 * data to be send to messenger platform 
 */


namespace Crazymeeks\MessengerBot\Builder\Composer;

use Crazymeeks\MessengerBot\Builder\FlowBuilder;
use Crazymeeks\MessengerBot\Builder\Composer\Exception\MessageTagRequiredException;

class Composer
{

    const MESSAGE_TAG = 'MESSAGE_TAG';
 
    /**
     * @var array
     */
    protected $markUp;
    
    public function __construct(array $markUp)
    {
        $this->markUp = $markUp;
    }


    /**
     * Compose the message to be send back to messenger
     *
     * @param \Crazymeeks\MessengerBot\Builder\FlowBuilder $flowBuilder
     * 
     * @return array
     */
    public function compose(FlowBuilder $flowBuilder)
    {

        $markUp = [
            'recipient' => [
                'id' => $flowBuilder->getRecipientId(),
            ],
            'message' => $this->markUp['message']
        ];

        if (isset($this->markUp['message_type'])) {
            $messageType = $this->markUp['message_type'];
            $type = strtoupper($messageType['type']);
            if ($type === self::MESSAGE_TAG) {
                // make sure <tag> is present
                if (!isset($messageType['tag'])) {
                    throw new MessageTagRequiredException();
                }
                // tag must be same with the tags defined by
                // facebook.
                // @see https://developers.facebook.com/docs/messenger-platform/send-messages/message-tags/
                $markUp['tag'] = strtoupper($messageType['tag']);
            }
            $markUp['message_type'] = $type;
        }
        
        return $markUp;
    }
}