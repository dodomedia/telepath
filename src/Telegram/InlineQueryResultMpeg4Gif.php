<?php

/**
 * This file is auto-generated.
 */

namespace Tii\Telepath\Telegram;

class InlineQueryResultMpeg4Gif extends InlineQueryResult
{
	public string $type;
	public string $id;
	public string $mpeg4_url;
	public int $mpeg4_width;
	public int $mpeg4_height;
	public int $mpeg4_duration;
	public string $thumb_url;
	public string $thumb_mime_type;
	public string $title;
	public string $caption;
	public string $parse_mode;

	/** @var MessageEntity[] */
	public array $caption_entities;
	public InlineKeyboardMarkup $reply_markup;
	public InputMessageContent $input_message_content;
}
