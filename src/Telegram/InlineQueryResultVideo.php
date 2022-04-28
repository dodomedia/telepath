<?php

/**
 * This file is auto-generated.
 */

namespace Tii\Telepath\Telegram;

class InlineQueryResultVideo extends InlineQueryResult
{
	public string $type;
	public string $id;
	public string $video_url;
	public string $mime_type;
	public string $thumb_url;
	public string $title;
	public string $caption;
	public string $parse_mode;

	/** @var MessageEntity[] */
	public array $caption_entities;
	public int $video_width;
	public int $video_height;
	public int $video_duration;
	public string $description;
	public InlineKeyboardMarkup $reply_markup;
	public InputMessageContent $input_message_content;
}
