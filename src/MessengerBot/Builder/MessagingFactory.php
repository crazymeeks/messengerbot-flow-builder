<?php

namespace Crazymeeks\MessengerBot\Builder;

use Crazymeeks\MessengerBot\Builder\Messaging\QuickReplies;

class MessagingFactory
{

    /**
     * Create messaging class based on markup
     *
     * @param array $markup
     * @param mixed $facebookProfile
     * 
     * @return \Crazymeeks\MessengerBot\Builder\Messaging\MessagingInterface
     */
    public static function createFromMarkup(array $markup, $facebookProfile = null)
    {
        if (isset($markup['message']['quick_replies'])) {
            return new QuickReplies($markup, $facebookProfile);
        }

    }
}