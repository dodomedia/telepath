<?php

/**
 * This file is auto-generated.
 */

namespace Tii\Telepath\Telegram;

/**
 * This object contains information about one member of a chat. Currently, the following 6 types of chat members are supported:
 */
class ChatMember extends \Tii\Telepath\Type
{
	/** The member's status in the chat */
	public string $status;

	/** Information about the user */
	public User $user;
}
