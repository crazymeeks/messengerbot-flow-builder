<?php

namespace Crazymeeks\MessengerBot\Builder\Messaging;

use function is_multi_array;
use Crazymeeks\MessengerBot\Builder\Messaging\AbstractBase;

class QuickReplies extends AbstractBase
{
    
    /**
     * @inheritDoc
     */
    public function getBody()
    {
        $markUp = $this->markup;
        
        $name = 'There';
        
        if (is_object($this->facebookProfile)) {
            $name = $this->facebookProfile->first_name;
        }

        $markUp['message']['text'] = findReplace($markUp['message']['text'], 'firstname', $name);
        
        $quickReplies = $markUp['message']['quick_replies'];
        
        if (!is_multi_array($quickReplies)) {
            $quickReplies = [
                $quickReplies
            ];
            $markUp['message']['quick_replies'] = $quickReplies;
        }
        
        foreach($markUp['message']['quick_replies'] as $key => $qr){
            $markUp['message']['quick_replies'][$key]['payload'] = json_encode($markUp['message']['quick_replies'][$key]['payload']);
            unset($key, $qr);
        }

        return $markUp;
    }
}