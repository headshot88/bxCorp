<?php
namespace Bitrix\Crm\Counter;
use Bitrix\Crm\Service\Container;
use Bitrix\Main;

class EntityCounterType
{
	const UNDEFINED = 0;
	const IDLE  = 1;
	const PENDING = 2;
	const OVERDUE = 4;

	const CURRENT = 6;  //PENDING|OVERDUE
	const ALL = 7;  //IDLE|PENDING|OVERDUE

	const FIRST = 1;
	const LAST = 4;

	const IDLE_NAME  = 'IDLE';
	const PENDING_NAME = 'PENDING';
	const OVERDUE_NAME = 'OVERDUE';
	const CURRENT_NAME = 'CURRENT';
	const ALL_NAME = 'ALL';

	private static $all = null;

	/**
	 * @param int $typeID Type ID.
	 * @return bool
	 */
	public static function isDefined($typeID)
	{
		if(!is_numeric($typeID))
		{
			return false;
		}

		if(!is_int($typeID))
		{
			$typeID = (int)$typeID;
		}

		return $typeID === self::IDLE
			|| $typeID === self::PENDING
			|| $typeID === self::OVERDUE
			|| $typeID === self::CURRENT
			|| $typeID === self::ALL;
	}
	public static function isGrouping($typeID)
	{
		return in_array($typeID, self::getGroupings());
	}
	/**
	 * Check if specified counter type is supported for specified entity type.
	 * @param int $typeID Entity Counter Type ID.
	 * @param int $entityTypeID Entity Type ID.
	 * @return bool
	 */
	public static function isSupported($typeID, $entityTypeID)
	{
		$typeID = (int)$typeID;
		$entityTypeID = (int)$entityTypeID;
		$factory = Container::getInstance()->getFactory($entityTypeID);

		return ($factory && $factory->getCountersSettings()->isCounterTypeEnabled($typeID));
	}
	/**
	 * @param int $typeID Type ID.
	 * @return string
	 */
	public static function resolveName($typeID)
	{
		if(!is_numeric($typeID))
		{
			return '';
		}

		$typeID = (int)$typeID;

		if($typeID === self::IDLE)
		{
			return self::IDLE_NAME;
		}
		elseif($typeID === self::PENDING)
		{
			return self::PENDING_NAME;
		}
		elseif($typeID === self::OVERDUE)
		{
			return self::OVERDUE_NAME;
		}
		elseif($typeID === self::CURRENT)
		{
			return self::CURRENT_NAME;
		}
		elseif($typeID === self::ALL)
		{
			return self::ALL_NAME;
		}
		return '';
	}
	/**
	 * @param string $typeName Type Name.
	 * @return int
	 */
	public static function resolveID($typeName)
	{
		if(!is_string($typeName))
		{
			return self::UNDEFINED;
		}

		$typeName = mb_strtoupper($typeName);
		if($typeName === self::IDLE_NAME)
		{
			return self::IDLE;
		}
		elseif($typeName === self::PENDING_NAME)
		{
			return self::PENDING;
		}
		elseif($typeName === self::OVERDUE_NAME)
		{
			return self::OVERDUE;
		}
		elseif($typeName === self::CURRENT_NAME)
		{
			return self::CURRENT;
		}
		elseif($typeName === self::ALL_NAME)
		{
			return self::ALL;
		}
		return self::UNDEFINED;
	}
	/**
	 * @return array
	 */
	public static function getAll($enableGrouping = false)
	{
		if(self::$all === null)
		{
			self::$all = array(self::IDLE, self::PENDING, self::OVERDUE);
		}

		if(!$enableGrouping)
		{
			return self::$all;
		}
		return array_merge(self::$all, self::getGroupings());
	}

	/**
	 * @param $entityTypeID
	 * @param bool $enableGrouping
	 * @return array
	 */
	public static function getAllSupported($entityTypeID, $enableGrouping = false)
	{
		$entityTypeID = (int)$entityTypeID;
		$factory = Container::getInstance()->getFactory($entityTypeID);
		if (!$factory)
		{
			return [];
		}

		$countersTypes = $factory->getCountersSettings()->getEnabledCountersTypes();

		if (!$enableGrouping)
		{
			$countersTypes = array_diff($countersTypes, self::getGroupings());
		}

		return $countersTypes;
	}

	public static function getGroupings()
	{
		return array(self::CURRENT, self::ALL);
	}
	public static function joinType(array $typeIDs)
	{
		$result = 0;
		foreach($typeIDs as $typeID)
		{
			$result |= $typeID;
		}
		return $result;
	}
	public static function splitType($typeID)
	{
		if(!is_numeric($typeID))
		{
			return array();
		}

		if(!is_int($typeID))
		{
			$typeID = (int)$typeID;
		}

		$results = array();
		foreach(self::getAll() as $ID)
		{
			if(($typeID&$ID) === $ID)
			{
				$results[] = $ID;
			}
		}
		return $results;
	}

	public static function getListFilterInfo(array $params = null, array $options = null)
	{
		Main\Localization\Loc::loadMessages(__FILE__);

		if($params === null)
		{
			$params = [];
		}

		if($options === null)
		{
			$options = [];
		}
		$entityTypeId = (int)($options['ENTITY_TYPE_ID'] ?? \CCrmOwnerType::Undefined);

		$items = [];
		if(!(isset($params['params']) && isset($params['params']['multiple']) && strcasecmp($params['params']['multiple'], 'Y') === 0))
		{
			//Add 'Not Selected' for single filter
			$items[''] = '';
		}

		$entityTypeId = (int)$entityTypeId;
		$factory = Container::getInstance()->getFactory($entityTypeId);
		if (!$factory)
		{
			return [];
		}

		$countersSettings = $factory->getCountersSettings();

		if ($countersSettings->isIdleCounterEnabled())
		{
			$items[self::IDLE] = GetMessage('CRM_ENTITY_COUNTER_TYPE_FILTER_IDLE');
		}
		if ($countersSettings->isPendingCounterEnabled())
		{
			$items[self::PENDING] = GetMessage('CRM_ENTITY_COUNTER_TYPE_FILTER_PENDING');
		}
		if ($countersSettings->isOverdueCounterEnabled())
		{
			$items[self::OVERDUE] = GetMessage('CRM_ENTITY_COUNTER_TYPE_FILTER_OVERDUE');
		}

		return array_merge(
			[
				'type' => 'list',
				'items' => $items,
			],
			$params
		);
	}
}
