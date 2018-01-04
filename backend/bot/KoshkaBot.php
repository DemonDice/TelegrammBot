<?php

/*
 * Copyright (C) 2018 Olga Pshenichnikova <olga@technofractal.org>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU General Public License
 * as published by the Free Software Foundation; either version 2
 * of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
 */

namespace bot;

use \Telegram\Bot\Api;

/**
 * Description of KoshkaBot
 *
 * @author Olga Pshenichnikova <olga@technofractal.org>
 */
class KoshkaBot 
{
	public function handleRequest(Api $api) : bool
	{
		$result = $api->getWebhookUpdates();
		
		if (!isset($result["message"]))
		{
			return false;
		}

		//Текст сообщения
		$text = $result["message"]["text"];
		//Уникальный идентификатор пользователя
		$chat_id = $result["message"]["chat"]["id"];
		$user = $result["message"]["from"]["first_name"];
		
		$api->sendMessage([ 
			'chat_id' => $chat_id, 
			'text' => $user 
		]);
		
		return true;
		
		//Юзернейм пользователя
		$name = $result["message"]["from"]["username"];
		//Клавиатура
		$keyboard = [
			["Кошке нужна валерьянка"],
			["Мишка )"]
		];

		if($text) {
			 if ($text == "/start") {
				$reply = "Добро пожаловать в КошкинБот!";
				$reply_markup = $telegram->replyKeyboardMarkup([ 
					'keyboard' => $keyboard, 
					'resize_keyboard' => true, 
					'one_time_keyboard' => false 
				]);

				$api->sendMessage([ 
					'chat_id' => $chat_id, 
					'text' => $reply, 
					'reply_markup' => $reply_markup 
				]);
			} elseif ($text == "/help") {
				$reply = "Слава Котам!!!";
				$telegram->sendMessage([ 
					'chat_id' => $chat_id, 
					'text' => $reply 
				]);
			} elseif ($text == "Кошке нужна валерьянка") {
				$api->sendSticker([ 
					'chat_id' => $chat_id, 
					'sticker' => 'CAADBAADxgMAAv4zDQY6bEeD67rtlAI'
				]);
			} elseif ($text == "Мишка )") {
				$api->sendSticker([ 
					'chat_id' => $chat_id, 
					'sticker' => 'CAADAgADnQQAAmvEygrzEw25pNCS5wI'
				]);
			} else {
				$reply = "По запросу \"<b>".$text."</b>\" ничего не найдено.";
				$api->sendMessage([ 
					'chat_id' => $chat_id, 
					'parse_mode'=> 'HTML', 
					'text' => $reply 
				]);
			}
		}else{
			$api->sendMessage([ 
				'chat_id' => $chat_id, 
				'text' => "Отправьте текстовое сообщение." 
			]);

			/*$debug = print_r($result, true);

			$telegram->sendMessage([ 
				'chat_id' => $chat_id, 
				'parse_mode' => 'Markdown', 
				'disable_web_page_preview' => true, 
				'text' => "```$debug```"
			]);*/
		}
		
		return true;
	}
}