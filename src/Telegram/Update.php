<?php
/**
 * This file was automatically generated!
 */


namespace Tii\Telepath\Telegram;

class Update extends \Tii\Telepath\Type
{
    public int $update_id;

    public Message $message;

    public Message $edited_message;

    public Message $channel_post;

    public Message $edited_channel_post;

    public InlineQuery $inline_query;

    public ChosenInlineResult $chosen_inline_result;

    public CallbackQuery $callback_query;

    public ShippingQuery $shipping_query;

    public PreCheckoutQuery $pre_checkout_query;

    public Poll $poll;

    public PollAnswer $poll_answer;

    public ChatMemberUpdated $my_chat_member;

    public ChatMemberUpdated $chat_member;

    public ChatJoinRequest $chat_join_request;

    public function __construct(array $data = [])
    {
        parent::__construct($data);
    }
}

