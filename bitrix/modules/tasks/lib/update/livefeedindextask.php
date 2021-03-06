<?php

namespace Bitrix\Tasks\Update;

use Bitrix\Main\Update\Stepper;
use Bitrix\Main\Localization\Loc;
use Bitrix\Tasks\Integration;
use Bitrix\Socialnetwork\Item\LogIndex;
use Bitrix\Socialnetwork\LogTable;
use Bitrix\Socialnetwork\LogIndexTable;
use Bitrix\Main\Config\Option;
use Bitrix\Main\Loader;

Loc::loadMessages(__FILE__);

final class LivefeedIndexTask extends Stepper
{
	protected static $moduleId = 'tasks';

	public function execute(array &$result): bool
	{
		if (
			!Loader::includeModule('tasks')
			|| !Loader::includeModule('socialnetwork')
			|| Option::get('tasks', 'needLivefeedIndex', 'Y') !== 'Y'
		)
		{
			return false;
		}

		$return = false;

		$params = Option::get('tasks', 'livefeedindextask', '');
		$params = ($params !== "" ? @unserialize($params, ['allowed_classes' => false]) : []);
		$params = (is_array($params) ? $params : []);
		if (empty($params))
		{
			$params = [
				"lastId" => 0,
				"number" => 0,
				"count" => LogTable::getCount(
					[
						'@EVENT_ID' => Integration\Socialnetwork\Log::getEventIdList(),
						'!SOURCE_ID' => false,
					]
				),
			];
		}

		$found = false;

		if ($params["count"] > 0)
		{
			$result["title"] = Loc::getMessage("FUPD_LF_TASKS_TASK_INDEX_TITLE");
			$result["progress"] = 1;
			$result["steps"] = "";
			$result["count"] = $params["count"];

			$res = LogTable::getList([
				'order' => [ 'ID' => 'ASC' ],
				'filter' => [
					'>ID' => $params["lastId"],
					'@EVENT_ID' => Integration\Socialnetwork\Log::getEventIdList(),
					'!SOURCE_ID' => false
				],
				'select' => [ 'ID', 'EVENT_ID', 'SOURCE_ID' ],
				'offset' => 0,
				'limit' => 100,
			]);

			while ($record = $res->fetch())
			{
				LogIndex::setIndex([
					'itemType' => LogIndexTable::ITEM_TYPE_LOG,
					'itemId' => $record['ID'],
					'fields' => $record,
				]);

				$params["lastId"] = $record['ID'];
				$params["number"]++;
				$found = true;
			}

			if ($found)
			{
				Option::set("tasks", "livefeedindextask", serialize($params));
				$return = true;
			}

			$result["progress"] = intval($params["number"] * 100/ $params["count"]);
			$result["steps"] = $params["number"];
		}

		if ($found === false)
		{
			Option::delete("tasks", [ 'name' => 'livefeedindextask' ]);
			Option::set('tasks', 'needLivefeedIndex', 'N');
		}

		return $return;
	}
}
