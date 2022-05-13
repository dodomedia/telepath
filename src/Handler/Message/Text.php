<?php

namespace Tii\Telepath\Handler\Message;

use Tii\Telepath\Handler\Message;
use Tii\Telepath\MatchMaker\MatchMaker;
use Tii\Telepath\Telegram\Update;
use Tii\Telepath\TelegramBot;

#[\Attribute(\Attribute::TARGET_METHOD | \Attribute::IS_REPEATABLE)]
class Text extends Message
{
    public function __construct(
        protected ?string $exact = null,
        protected ?string $prefix = null,
        protected ?string $regex = null,
        protected ?string $suffix = null,
        protected ?bool $is_numeric = null,
    ) {}

    public function responsible(Update $update, TelegramBot $bot): bool
    {
        if (! parent::responsible($update, $bot)) {
            return false;
        }

        $text = $update->message->text;

        return MatchMaker::conjunction($text)
            ->exact($this->exact)
            ->prefix($this->prefix)
            ->regex($this->regex)
            ->suffix($this->suffix)
            ->is_numeric($this->is_numeric)
            ->result();
    }
}