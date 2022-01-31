<?php

namespace Crazymeeks\MessengerBot\Builder;

use LogicException;
use Crazymeeks\MessengerBot\Builder\FlowBuilder;
use Crazymeeks\MessengerBot\Builder\ClassBuilder;
use Crazymeeks\MessengerBot\Builder\Messaging\SendingText;
use Crazymeeks\MessengerBot\Builder\Messaging\SendingTextWithAttachment;
use Crazymeeks\MessengerBot\Builder\Messaging\QuickReplies\QuickReplies;

class MessagingFactory
{

    protected $simpleMessageAttachmentTypes = [
        'audio',
        'video',
        'image',
        'file',
    ];

    protected $messageTemplateType = 'template';


    /**
     * Create messaging class based on markup
     *
     * @param array $markup
     * @param \Crazymeeks\MessengerBot\Builder\FlowBuilder $flowBuilder
     * @param mixed $facebookProfile
     * 
     * @return \Crazymeeks\MessengerBot\Builder\Messaging\MessagingInterface
     */
    public static function createFromMarkup(array $markup, FlowBuilder $flowBuilder, $facebookProfile = null)
    {
        
        if (isset($markup['message']['quick_replies'])) {
            return new QuickReplies($markup, $flowBuilder, $facebookProfile);
        }

        // Sending simple text
        if (count($markup['message']) === 1 && isset($markup['message']['text'])) {
            return new SendingText($markup, $flowBuilder, $facebookProfile);
        }

        // Sending text with attachment
        if (isset($markup['message']['attachment']['type'])) {
            $type = strtolower($markup['message']['attachment']['type']);
            $me = new static();
            if (in_array($type, $me->simpleMessageAttachmentTypes)) {
                return new SendingTextWithAttachment($markup, $flowBuilder, $facebookProfile);
            }

            // template
            if ($type === $me->messageTemplateType) {
                // instantiate the template class
                $template =  "\Crazymeeks\MessengerBot\Builder\Messaging\Templates\\" . ucfirst($markup['message']['attachment']['payload']['template_type']);
                return new $template($markup, $flowBuilder, $facebookProfile);
            }
        }
        
        if (isset($markup['message'])) {

            if (isset($markup['message']['class'])) {
                
                $markup['message']['class'] =  [$markup['message']['class']];
            }

            if (isset($markup['message'][0]['class'])) {
                foreach($markup['message'] as $key => $namespace){
                    $markup['message']['class'][] = $namespace['class'];
                    unset($markup['message'][$key]);
                }
            }

            return new ClassBuilder($markup, $flowBuilder, $facebookProfile);
        }

        throw new LogicException("Cannot find specific action due to invalid xml markup. Please check your xml markup!");
    }
}