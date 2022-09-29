<?php

namespace Telepath\Handlers;

use Telepath\Telegram\Update;
use Telepath\TelegramBot;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class PollAnswer extends Handler
{

    public function responsible(TelegramBot $bot, Update $update): bool
    {
        return $update->poll_answer !== null;
    }
}