<?php
namespace Bitrix\Crm\Timeline;

use Bitrix\Main;
use Bitrix\Main\Type\DateTime;
use Bitrix\Crm\Timeline\Entity\TimelineTable;

class ExternalNoticeEntry extends TimelineEntry
{
	public static function create(array $params)
	{
		$entityID = isset($params['ENTITY_ID']) ? (int)$params['ENTITY_ID'] : 0;
		if ($entityID <= 0)
		{
			throw new Main\ArgumentException('Entity ID must be greater than zero.', 'entityID');
		}

		$entityTypeID = isset($params['ENTITY_TYPE_ID']) ? (int)$params['ENTITY_TYPE_ID'] : 0;
		if ($entityTypeID <= 0)
		{
			throw new Main\ArgumentException('Entity ID must be greater than zero.', 'entityID');
		}

		$categoryID = isset($params['TYPE_CATEGORY_ID']) ? (int)$params['TYPE_CATEGORY_ID'] : 0;
		if ($categoryID <= 0)
		{
			throw new Main\ArgumentException('Category Id must be greater than zero.', 'authorID');
		}


		$authorID = isset($params['AUTHOR_ID']) ? (int)$params['AUTHOR_ID'] : 0;
		if (!is_int($authorID))
		{
			$authorID = (int)$authorID;
		}

		if ($authorID <= 0)
		{
			throw new Main\ArgumentException('Author ID must be greater than zero.', 'authorID');
		}

		$created = isset($params['CREATED']) && ($params['CREATED'] instanceof DateTime)
			? $params['CREATED'] : new DateTime();

		$settings = isset($params['SETTINGS']) && is_array($params['SETTINGS']) ? $params['SETTINGS'] : [];

		$result = TimelineTable::add(
			array(
				'TYPE_ID' => TimelineType::EXTERNAL_NOTICE,
				'TYPE_CATEGORY_ID' => $categoryID,
				'ASSOCIATED_ENTITY_ID' => $params['ENTITY_ID'] ?? '',
				'ASSOCIATED_ENTITY_TYPE_ID' => $params['ENTITY_TYPE_ID'] ?? '',
				'CREATED' => $created,
				'AUTHOR_ID' => $authorID,
				'SETTINGS' => $settings
			)
		);

		if (!$result->isSuccess())
		{
			return 0;
		}

		$ID = $result->getId();
		$bindings = isset($params['BINDINGS']) && is_array($params['BINDINGS']) ? $params['BINDINGS'] : array();
		if(empty($bindings))
		{
			$bindings[] = array('ENTITY_TYPE_ID' => $entityTypeID, 'ENTITY_ID' => $entityID);
		}
		self::registerBindings($ID, $bindings);
		return $ID;
	}
}