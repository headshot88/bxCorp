<?php
namespace Bitrix\Crm\Timeline;

use Bitrix\Crm\Service\Container;
use Bitrix\Main;
use Bitrix\Main\DI\ServiceLocator;
use Bitrix\Main\Type\DateTime;

class Controller
{
	/** @var int|null */
	protected static $defaultAuthorId;

	/**
	 * Get an instance of the controller
	 *
	 * @return static
	 */
	public static function getInstance()
	{
		if (!ServiceLocator::getInstance()->has(static::getServiceLocatorIdentifier()))
		{
			$instance = new static();
			ServiceLocator::getInstance()->addInstance(static::getServiceLocatorIdentifier(), $instance);
		}

		return ServiceLocator::getInstance()->get(static::getServiceLocatorIdentifier());
	}

	protected static function getServiceLocatorIdentifier(): string
	{
		return Container::getIdentifierByClassName(static::class);
	}

	/**
	 * Prepare data about an timeline entry. The data is used in interface to display timeline event
	 *
	 * @param array $data
	 * @param array|null $options = [
	 *     'ENABLE_USER_INFO' => false, // prepare detailed author info (link, image, name). Disabled by default
	 * ];
	 *
	 * @return array
	 */
	public function prepareHistoryDataModel(array $data, array $options = null)
	{
		if(!is_array($options))
		{
			$options = array();
		}

		if(isset($options['ENABLE_USER_INFO']) && $options['ENABLE_USER_INFO'] === true)
		{
			self::prepareAuthorInfo($data);
		}

		if(isset($data['CREATED']) && $data['CREATED'] instanceof DateTime)
		{
			$data['CREATED_SERVER'] = $data['CREATED']->format('Y-m-d H:i:s');
		}

		unset($data['SETTINGS']);
		return $data;
	}
	public static function prepareAuthorInfo(array &$item)
	{
		$items = array($item);
		self::prepareAuthorInfoBulk($items);
		$item = $items[0];
	}
	public static function prepareAuthorInfoBulk(array &$items)
	{
		$userProfilePath = \COption::GetOptionString('crm', mb_strtolower('PATH_TO_USER_PROFILE'), '');
		if($userProfilePath === '')
		{
			$userProfilePath = '/company/personal/user/#user_id#/';
		}

		$userMap = array();
		foreach($items as $ID => &$item)
		{
			if(!is_array($item))
			{
				continue;
			}

			$authorID = isset($item['AUTHOR_ID']) ? (int)$item['AUTHOR_ID'] : 0;
			if($authorID <= 0)
			{
				continue;
			}

			if(!isset($userMap[$authorID]))
			{
				$userMap[$authorID] = array();
			}
			$userMap[$authorID][] = $ID;
		}
		unset($item);

		if(!empty($userMap))
		{
			$userIDs = array_keys($userMap);
			$dbResultUser = \CUser::GetList(
				'id',
				'asc',
				array('ID' => implode('|', $userIDs)),
				array('FIELDS' => array('ID', 'NAME', 'LAST_NAME', 'SECOND_NAME', 'LOGIN', 'TITLE', 'PERSONAL_PHOTO'))
			);

			while($user = $dbResultUser->Fetch())
			{
				$userID = (int)$user['ID'];

				$userName = \CUser::FormatName(
					\CSite::getNameFormat(), $user, true, false);

				foreach($userMap[$userID] as $ID)
				{
					$items[$ID]['AUTHOR'] = array(
						'FORMATTED_NAME' => $userName,
						'SHOW_URL' => \CComponentEngine::MakePathFromTemplate(
							$userProfilePath,
							array('user_id' => $userID)
						)
					);
				}

				$userPhoto = isset($user['PERSONAL_PHOTO']) ? $user['PERSONAL_PHOTO'] : '';
				if(!($userPhoto !== '' && isset($userMap[$userID])))
				{
					continue;
				}

				$fileInfo = \CFile::ResizeImageGet(
					$userPhoto,
					array('width' => 63, 'height' => 63),
					BX_RESIZE_IMAGE_EXACT
				);

				if(is_array($fileInfo) && isset($fileInfo['src']))
				{
					foreach($userMap[$userID] as $ID)
					{
						$items[$ID]['AUTHOR']['IMAGE_URL'] = $fileInfo['src'];
					}
				}
			}
		}
	}

	protected static function pushHistoryEntry($entryID, $tagName, $command)
	{
		if(!Main\Loader::includeModule('pull'))
		{
			return;
		}

		$params = array('TAG' => $tagName);
		$entryFields = TimelineEntry::getByID($entryID);
		if(is_array($entryFields))
		{
			TimelineManager::prepareItemDisplayData($entryFields);
			$params['HISTORY_ITEM'] = $entryFields;
		}

		\CPullWatch::AddToStack(
			$tagName,
			array(
				'module_id' => 'crm',
				'command' => $command,
				'params' => $params,
			)
		);
	}

	protected static function getDefaultAuthorId()
	{
		if (is_null(static::$defaultAuthorId))
		{
			$user = \CUser::GetList(
				'ID',
				'ASC',
				['GROUPS_ID' => [1], 'ACTIVE' => 'Y'],
				['FIELDS' => ['ID'], 'NAV_PARAMS' => ['nTopCount' => 1]]
			)->fetch();

			static::$defaultAuthorId = is_array($user) ? (int)$user['ID'] : 0;
		}

		return static::$defaultAuthorId;
	}

	protected static function getCurrentOrDefaultAuthorId(): int
	{
		$currentUserId = Container::getInstance()->getContext()->getUserId();

		return ($currentUserId > 0) ? $currentUserId : (int)static::getDefaultAuthorId();
	}
}