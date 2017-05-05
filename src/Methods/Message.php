<?php

namespace Telegram\Bot\Methods;

use Telegram\Bot\Exceptions\TelegramSDKException;
use Telegram\Bot\Objects\Message as MessageObject;

/**
 * Class Message
 */
trait Message
{
	/**
	 * Send text messages.
	 *
	 * <code>
	 * $params = [
	 *   'chat_id'                  => '',
	 *   'text'                     => '',
	 *   'parse_mode'               => '',
	 *   'disable_web_page_preview' => '',
	 *   'disable_notification'     => '',
	 *   'reply_to_message_id'      => '',
	 *   'reply_markup'             => '',
	 * ];
	 * </code>
	 *
	 * @link https://core.telegram.org/bots/api#sendmessage
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var string     $params ['text']
	 * @var string     $params ['parse_mode']
	 * @var bool       $params ['disable_web_page_preview']
	 * @var bool       $params ['disable_notification']
	 * @var int        $params ['reply_to_message_id']
	 * @var string     $params ['reply_markup']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return MessageObject
	 */
	public function sendMessage(array $params)
	{
		$response = $this->post('sendMessage', $params);

		return new MessageObject($response->getDecodedBody());
	}

	/**
	 * Forward messages of any kind.
	 *
	 * <code>
	 * $params = [
	 *   'chat_id'              => '',
	 *   'from_chat_id'         => '',
	 *   'disable_notification' => '',
	 *   'message_id'           => '',
	 * ];
	 * </code>
	 *
	 * @link https://core.telegram.org/bots/api#forwardmessage
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var int        $params ['from_chat_id']
	 * @var bool       $params ['disable_notification']
	 * @var int        $params ['message_id']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return MessageObject
	 */
	public function forwardMessage(array $params)
	{
		$response = $this->post('forwardMessage', $params);

		return new MessageObject($response->getDecodedBody());
	}

	/**
	 * Send Photos.
	 *
	 * <code>
	 * $params = [
	 *   'chat_id'              => '',
	 *   'photo'                => InputFile::create($resourceOrFile, $filename),
	 *   'caption'              => '',
	 *   'disable_notification' => '',
	 *   'reply_to_message_id'  => '',
	 *   'reply_markup'         => '',
	 * ];
	 * </code>
	 *
	 * @link https://core.telegram.org/bots/api#sendphoto
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var string     $params ['photo']
	 * @var string     $params ['caption']
	 * @var bool       $params ['disable_notification']
	 * @var int        $params ['reply_to_message_id']
	 * @var string     $params ['reply_markup']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return MessageObject
	 */
	public function sendPhoto(array $params)
	{
		$response = $this->uploadFile('sendPhoto', $params, 'photo');

		return new MessageObject($response->getDecodedBody());
	}

	/**
	 * Send regular audio files.
	 *
	 * <code>
	 * $params = [
	 *   'chat_id'              => '',
	 *   'audio'                => InputFile::create($resourceOrFile, $filename),
	 *   'caption'              => '',
	 *   'duration'             => '',
	 *   'performer'            => '',
	 *   'title'                => '',
	 *   'disable_notification' => '',
	 *   'reply_to_message_id'  => '',
	 *   'reply_markup'         => '',
	 * ];
	 * </code>
	 *
	 * @link https://core.telegram.org/bots/api#sendaudio
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var string     $params ['audio']
	 * @var string     $params ['caption']
	 * @var int        $params ['duration']
	 * @var string     $params ['performer']
	 * @var string     $params ['title']
	 * @var bool       $params ['disable_notification']
	 * @var int        $params ['reply_to_message_id']
	 * @var string     $params ['reply_markup']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return MessageObject
	 */
	public function sendAudio(array $params)
	{
		$response = $this->uploadFile('sendAudio', $params, 'audio');

		return new MessageObject($response->getDecodedBody());
	}

	/**
	 * Send general files.
	 *
	 * <code>
	 * $params = [
	 *   'chat_id'              => '',
	 *   'document'             => InputFile::create($resourceOrFile, $filename),
	 *   'caption'              => '',
	 *   'disable_notification' => '',
	 *   'reply_to_message_id'  => '',
	 *   'reply_markup'         => '',
	 * ];
	 * </code>
	 *
	 * @link https://core.telegram.org/bots/api#senddocument
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var string     $params ['document']
	 * @var string     $params ['caption']
	 * @var bool       $params ['disable_notification']
	 * @var int        $params ['reply_to_message_id']
	 * @var string     $params ['reply_markup']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return MessageObject
	 */
	public function sendDocument(array $params)
	{
		$response = $this->uploadFile('sendDocument', $params, 'document');

		return new MessageObject($response->getDecodedBody());
	}

	/**
	 * Send .webp stickers.
	 *
	 * <code>
	 * $params = [
	 *   'chat_id'              => '',
	 *   'sticker'              => InputFile::create($resourceOrFile, $filename),
	 *   'disable_notification' => '',
	 *   'reply_to_message_id'  => '',
	 *   'reply_markup'         => '',
	 * ];
	 * </code>
	 *
	 * @link https://core.telegram.org/bots/api#sendsticker
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var string     $params ['sticker']
	 * @var bool       $params ['disable_notification']
	 * @var int        $params ['reply_to_message_id']
	 * @var string     $params ['reply_markup']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return MessageObject
	 */
	public function sendSticker(array $params)
	{
		if (is_file($params['sticker']) && ( pathinfo($params['sticker'], PATHINFO_EXTENSION) !== 'webp' )) {
			throw new TelegramSDKException('Invalid Sticker Provided. Supported Format: Webp');
		}

		$response = $this->uploadFile('sendSticker', $params, 'sticker');

		return new MessageObject($response->getDecodedBody());
	}

	/**
	 * Send Video File, Telegram clients support mp4 videos (other formats may be sent as Document).
	 *
	 * <code>
	 * $params = [
	 *   'chat_id'              => '',
	 *   'video'                => InputFile::create($resourceOrFile, $filename),
	 *   'duration'             => '',
	 *   'width'                => '',
	 *   'height'               => '',
	 *   'caption'              => '',
	 *   'disable_notification' => '',
	 *   'reply_to_message_id'  => '',
	 *   'reply_markup'         => '',
	 * ];
	 * </code>
	 *
	 * @see  sendDocument
	 * @link https://core.telegram.org/bots/api#sendvideo
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var string     $params ['video']
	 * @var int        $params ['duration']
	 * @var int        $params ['width']
	 * @var int        $params ['height']
	 * @var string     $params ['caption']
	 * @var bool       $params ['disable_notification']
	 * @var int        $params ['reply_to_message_id']
	 * @var string     $params ['reply_markup']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return MessageObject
	 */
	public function sendVideo(array $params)
	{
		$response = $this->uploadFile('sendVideo', $params, 'video');

		return new MessageObject($response->getDecodedBody());
	}

	/**
	 * Send voice audio files.
	 *
	 * <code>
	 * $params = [
	 *   'chat_id'              => '',
	 *   'voice'                => InputFile::create($resourceOrFile, $filename),
	 *   'caption'              => '',
	 *   'duration'             => '',
	 *   'disable_notification' => '',
	 *   'reply_to_message_id'  => '',
	 *   'reply_markup'         => '',
	 * ];
	 * </code>
	 *
	 * @link https://core.telegram.org/bots/api#sendaudio
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var string     $params ['voice']
	 * @var string     $params ['caption']
	 * @var int        $params ['duration']
	 * @var bool       $params ['disable_notification']
	 * @var int        $params ['reply_to_message_id']
	 * @var string     $params ['reply_markup']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return MessageObject
	 */
	public function sendVoice(array $params)
	{
		$response = $this->uploadFile('sendVoice', $params, 'voice');

		return new MessageObject($response->getDecodedBody());
	}

	/**
	 * Send point on the map.
	 *
	 * <code>
	 * $params = [
	 *   'chat_id'              => '',
	 *   'latitude'             => '',
	 *   'longitude'            => '',
	 *   'disable_notification' => '',
	 *   'reply_to_message_id'  => '',
	 *   'reply_markup'         => '',
	 * ];
	 * </code>
	 *
	 * @link https://core.telegram.org/bots/api#sendlocation
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var float      $params ['latitude']
	 * @var float      $params ['longitude']
	 * @var bool       $params ['disable_notification']
	 * @var int        $params ['reply_to_message_id']
	 * @var string     $params ['reply_markup']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return MessageObject
	 */
	public function sendLocation(array $params)
	{
		$response = $this->post('sendLocation', $params);

		return new MessageObject($response->getDecodedBody());
	}

	/**
	 * Send information about a venue.
	 *
	 * <code>
	 * $params = [
	 *   'chat_id'              => '',
	 *   'latitude'             => '',
	 *   'longitude'            => '',
	 *   'title'                => '',
	 *   'address'              => '',
	 *   'foursquare_id'        => '',
	 *   'disable_notification' => '',
	 *   'reply_to_message_id'  => '',
	 *   'reply_markup'         => '',
	 * ];
	 * </code>
	 *
	 * @link https://core.telegram.org/bots/api#sendvenue
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var float      $params ['latitude']
	 * @var float      $params ['longitude']
	 * @var string     $params ['title']
	 * @var string     $params ['address']
	 * @var string     $params ['foursquare_id']
	 * @var bool       $params ['disable_notification']
	 * @var int        $params ['reply_to_message_id']
	 * @var string     $params ['reply_markup']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return MessageObject
	 */
	public function sendVenue(array $params)
	{
		$response = $this->post('sendVenue', $params);

		return new MessageObject($response->getDecodedBody());
	}

	/**
	 * Send phone contacts.
	 *
	 * <code>
	 * $params = [
	 *   'chat_id'              => '',
	 *   'phone_number'         => '',
	 *   'first_name'           => '',
	 *   'last_name'            => '',
	 *   'disable_notification' => '',
	 *   'reply_to_message_id'  => '',
	 *   'reply_markup'         => '',
	 * ];
	 * </code>
	 *
	 * @link https://core.telegram.org/bots/api#sendcontact
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var string     $params ['phone_number']
	 * @var string     $params ['first_name']
	 * @var string     $params ['last_name']
	 * @var bool       $params ['disable_notification']
	 * @var int        $params ['reply_to_message_id']
	 * @var string     $params ['reply_markup']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return MessageObject
	 */
	public function sendContact(array $params)
	{
		$response = $this->post('sendContact', $params);

		return new MessageObject($response->getDecodedBody());
	}

	/**
	 * Broadcast a Chat Action.
	 *
	 * <code>
	 * $params = [
	 *   'chat_id' => '',
	 *   'action'  => '',
	 * ];
	 * </code>
	 *
	 * @link https://core.telegram.org/bots/api#sendchataction
	 *
	 * @param array    $params
	 *
	 * @var int|string $params ['chat_id']
	 * @var string     $params ['action']
	 *
	 * @throws TelegramSDKException
	 *
	 * @return bool
	 */
	public function sendChatAction(array $params)
	{
		$validActions = [
			'typing',
			'upload_photo',
			'record_video',
			'upload_video',
			'record_audio',
			'upload_audio',
			'upload_document',
			'find_location',
		];

		if (isset($params['action']) && in_array($params['action'], $validActions)) {
			$this->post('sendChatAction', $params);

			return true;
		}

		throw new TelegramSDKException('Invalid Action! Accepted value: ' . implode(', ', $validActions));
	}
}