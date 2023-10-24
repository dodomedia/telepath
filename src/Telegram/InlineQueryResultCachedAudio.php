<?php

/**
 * This file is auto-generated.
 */

namespace Telepath\Telegram;

/**
 * Represents a link to an MP3 audio file stored on the Telegram servers. By default, this audio file will be sent by the user. Alternatively, you can use <em>input_message_content</em> to send a message with the specified content instead of the audio.
 */
class InlineQueryResultCachedAudio extends InlineQueryResult
{
    /** Type of the result, must be <em>audio</em> */
    public string $type = 'audio';

    /** A valid file identifier for the audio file */
    public string $audio_file_id;

    /** <em>Optional</em>. Caption, 0-1024 characters after entities parsing */
    public ?string $caption = null;

    /** <em>Optional</em>. Mode for parsing entities in the audio caption. See <a href="https://core.telegram.org/bots/api#formatting-options">formatting options</a> for more details. */
    public ?string $parse_mode = null;

    /**
     * <em>Optional</em>. List of special entities that appear in the caption, which can be specified instead of <em>parse_mode</em>
     *
     * @var MessageEntity[]
     */
    public ?array $caption_entities = null;

    /** <em>Optional</em>. Content of the message to be sent instead of the audio */
    public ?InputMessageContent $input_message_content = null;

    /**
     * @param  string  $id Unique identifier for this result, 1-64 bytes
     * @param  string  $audio_file_id A valid file identifier for the audio file
     * @param  string  $caption <em>Optional</em>. Caption, 0-1024 characters after entities parsing
     * @param  string  $parse_mode <em>Optional</em>. Mode for parsing entities in the audio caption. See <a href="https://core.telegram.org/bots/api#formatting-options">formatting options</a> for more details.
     * @param  MessageEntity[]  $caption_entities <em>Optional</em>. List of special entities that appear in the caption, which can be specified instead of <em>parse_mode</em>
     * @param  InlineKeyboardMarkup  $reply_markup <em>Optional</em>. <a href="https://core.telegram.org/bots/features#inline-keyboards">Inline keyboard</a> attached to the message
     * @param  InputMessageContent  $input_message_content <em>Optional</em>. Content of the message to be sent instead of the audio
     */
    public static function make(
        string $id,
        string $audio_file_id,
        string $caption = null,
        string $parse_mode = null,
        array $caption_entities = null,
        InlineKeyboardMarkup $reply_markup = null,
        InputMessageContent $input_message_content = null,
    ): static {
        return new static([
            'id' => $id,
            'audio_file_id' => $audio_file_id,
            'caption' => $caption,
            'parse_mode' => $parse_mode,
            'caption_entities' => $caption_entities,
            'reply_markup' => $reply_markup,
            'input_message_content' => $input_message_content,
        ]);
    }
}
