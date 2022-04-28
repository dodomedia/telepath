<?php

/**
 * This file is auto-generated.
 */

namespace Tii\Telepath\Telegram;

/**
 * Represents a link to a video file stored on the Telegram servers. By default, this video file will be sent by the user with an optional caption. Alternatively, you can use input_message_content to send a message with the specified content instead of the video.
 */
class InlineQueryResultCachedVideo extends InlineQueryResult
{
	/** A valid file identifier for the video file */
	public string $video_file_id;

	/** Title for the result */
	public string $title;

	/** Optional. Short description of the result */
	public string $description;

	/** Optional. Caption of the video to be sent, 0-1024 characters after entities parsing */
	public string $caption;

	/** Optional. Mode for parsing entities in the video caption. See formatting options for more details. */
	public string $parse_mode;

	/**
	 * Optional. List of special entities that appear in the caption, which can be specified instead of parse_mode
	 * @var MessageEntity[]
	 */
	public array $caption_entities;

	/** Optional. Content of the message to be sent instead of the video */
	public InputMessageContent $input_message_content;
}
