<?php

namespace Bitrix\Crm\Integrity;

use Bitrix\Crm\Communication\Type;
use Bitrix\Crm\Item;
use Bitrix\Main;

class DuplicateManager
{
	public static function getCriterionRegistrar(int $entityTypeId): CriterionRegistrar
	{
		if ($entityTypeId === \CCrmOwnerType::Lead)
		{
			return new CriterionRegistrar\Decorator\OrganizationCriterion(
				new CriterionRegistrar\Decorator\PersonCriterion(
					new CriterionRegistrar\Decorator\CommunicationCriterion(
						new CriterionRegistrar\EntityRanking(),
					),
				),
				Item\Lead::FIELD_NAME_COMPANY_TITLE,
			);
		}

		if ($entityTypeId === \CCrmOwnerType::Company)
		{
			return new CriterionRegistrar\Decorator\OrganizationCriterion(
				new CriterionRegistrar\Decorator\CommunicationCriterion(
					new CriterionRegistrar\EntityRanking(),
				),
				Item::FIELD_NAME_TITLE,
			);
		}

		if ($entityTypeId === \CCrmOwnerType::Contact)
		{
			return new CriterionRegistrar\Decorator\PersonCriterion(
				new CriterionRegistrar\Decorator\CommunicationCriterion(
					new CriterionRegistrar\EntityRanking(),
				),
			);
		}

		return new CriterionRegistrar\NullRegistrar();
	}

	/**
	* @return DuplicateCriterion
	*/
	public static function createCriterion($typeID, array $matches)
	{
		if(!is_int($typeID))
		{
			$typeID = (int)$typeID;
		}

		if ($typeID === DuplicateIndexType::PERSON)
		{
			return DuplicatePersonCriterion::createFromMatches($matches);
		}
		elseif ($typeID === DuplicateIndexType::ORGANIZATION)
		{
			return DuplicateOrganizationCriterion::createFromMatches($matches);
		}
		elseif (
			$typeID === DuplicateIndexType::COMMUNICATION_PHONE
			|| $typeID === DuplicateIndexType::COMMUNICATION_EMAIL
			|| $typeID === DuplicateIndexType::COMMUNICATION_SLUSER
		)
		{
			if (!isset($matches['TYPE']))
			{
				$matches['TYPE'] = Type::PHONE_NAME;

				if ($typeID === DuplicateIndexType::COMMUNICATION_PHONE)
				{
					$matches['TYPE'] = Type::PHONE_NAME;
				}
				elseif ($typeID === DuplicateIndexType::COMMUNICATION_EMAIL)
				{
					$matches['TYPE'] = Type::EMAIL_NAME;
				}
				elseif ($typeID === DuplicateIndexType::COMMUNICATION_SLUSER)
				{
					$matches['TYPE'] = Type::SLUSER_NAME;
				}
			}

			return DuplicateCommunicationCriterion::createFromMatches($matches);
		}
		elseif(($typeID & DuplicateIndexType::REQUISITE) === $typeID)
		{
			return DuplicateRequisiteCriterion::createFromMatches($matches);
		}
		elseif(($typeID & DuplicateIndexType::BANK_DETAIL) === $typeID)
		{
			return DuplicateBankDetailCriterion::createFromMatches($matches);
		}
		else
		{
			throw new Main\NotSupportedException("Criterion type(s): '".DuplicateIndexType::resolveName($typeID)."' is not supported in current context");
		}
	}
	/**
	* @return Duplicate
	*/
	public static function createDuplicate($typeID, array $matches, $entityTypeID, $rootEntityID, $userID, $enablePermissionCheck, $enableRanking, $limit = 0)
	{
		return self::createCriterion($typeID, $matches)->createDuplicate($entityTypeID, $rootEntityID, $userID, $enablePermissionCheck, $enableRanking, $limit);
	}
	/**
	* @return DuplicateIndexBuilder
	*/
	public static function createIndexBuilder($typeID, $entityTypeID, $userID, $enablePermissionCheck = false, $options = null)
	{
		$scope = self::parseScopeOption($options);

		return new DuplicateIndexBuilder($typeID, new DedupeParams($entityTypeID, $userID, $enablePermissionCheck, $scope));
	}
	/**
	 * @return DuplicateIndexBuilder
	 */
	public static function createAutomaticIndexBuilder($typeID, $entityTypeID, $userID, $enablePermissionCheck = false, $options = null)
	{
		$scope = self::parseScopeOption($options);
		$params = new DedupeParams($entityTypeID, $userID, $enablePermissionCheck, $scope);

		if (isset($options['LAST_INDEX_DATE']) && $options['LAST_INDEX_DATE'] instanceof Main\Type\DateTime)
		{
			$params->setIndexDate($options['LAST_INDEX_DATE']);
		}
		if (isset($options['CHECK_CHANGED_ONLY']) && $options['CHECK_CHANGED_ONLY'])
		{
			$params->setCheckChangedOnly(true);
		}
		return new AutomaticDuplicateIndexBuilder($typeID, $params);
	}
	public static function setDuplicateIndexItemStatus(
		$userID,
		$entityTypeID,
		$typeID,
		$matchHash,
		$scope,
		$statusID,
		$isAutomatic
	)
	{
		if ($isAutomatic)
		{
			AutomaticDuplicateIndexBuilder::setStatusID(
				$userID,
			$entityTypeID,
				$typeID,
				$matchHash,
			$scope,
				$statusID
		);
		}
		else
		{
			DuplicateIndexBuilder::setStatusID(
				$userID,
				$entityTypeID,
				$typeID,
				$matchHash,
				$scope,
				$statusID
			);
		}
	}
	public static function deleteDuplicateIndexItems($filter, $isAutomatic)
	{
		if ($isAutomatic)
		{
			Entity\AutomaticDuplicateIndexTable::deleteByFilter($filter);
		}
		else
		{
			Entity\DuplicateIndexTable::deleteByFilter($filter);
		}
	}

	public static function getExistedTypeScopeMap(int $entityTypeId, int $userId, bool $isAutomatic)
	{
		if ($isAutomatic)
		{
			return AutomaticDuplicateIndexBuilder::getExistedTypeScopeMap($entityTypeId, $userId);
		}
		else
		{
			return DuplicateIndexBuilder::getExistedTypeScopeMap($entityTypeId, $userId);
		}
	}

	public static function markDuplicateIndexAsJunk($entityTypeID, $entityID)
	{
		DuplicateIndexBuilder::markAsJunk($entityTypeID, $entityID);
		AutomaticDuplicateIndexBuilder::markAsDirty($entityTypeID, $entityID);
	}
	public static function markDuplicateIndexAsDirty($entityTypeID, $entityID)
	{
		AutomaticDuplicateIndexBuilder::markAsDirty($entityTypeID, $entityID);
	}

	public static function onChangeEntityAssignedBy($entityTypeID, $entityID)
	{
		DuplicateEntityMatchHash::setDateModify($entityTypeID, $entityID);
	}
	public static function removeIndexes(array $typeIDs, $entityTypeID, $userID, $enablePermissionCheck = false, $options = null)
	{
		$scope = self::parseScopeOption($options);
		$params = new DedupeParams($entityTypeID, $userID, $enablePermissionCheck, $scope);
		foreach($typeIDs as $typeID)
		{
			$builder = new DuplicateIndexBuilder($typeID, $params);
			$builder->remove();
		}
	}
	public static function getMatchHash($typeID, array $matches)
	{
		if($typeID === DuplicateIndexType::PERSON)
		{
			return DuplicatePersonCriterion::prepareMatchHash($matches);
		}
		elseif($typeID === DuplicateIndexType::ORGANIZATION)
		{
			return DuplicateOrganizationCriterion::prepareMatchHash($matches);
		}
		elseif($typeID === DuplicateIndexType::COMMUNICATION_EMAIL
			|| $typeID === DuplicateIndexType::COMMUNICATION_PHONE
			|| $typeID === DuplicateIndexType::COMMUNICATION_SLUSER)
		{
			return DuplicateCommunicationCriterion::prepareMatchHash($matches);
		}
		elseif(($typeID & DuplicateIndexType::REQUISITE) === $typeID)
		{
			return DuplicateRequisiteCriterion::createFromMatches($matches);
		}
		elseif(($typeID & DuplicateIndexType::BANK_DETAIL) === $typeID)
		{
			return DuplicateBankDetailCriterion::createFromMatches($matches);
		}

		throw new Main\NotSupportedException("Criterion type(s): '".DuplicateIndexType::resolveName($typeID)."' is not supported in current context");
	}
	/**
	 * Get types supported by deduplication system for specified entity type.
	 * @param int $entityTypeID Entity Type ID.
	 * @return array
	 */
	public static function getSupportedDedupeTypes($entityTypeID)
	{
		$entityTypeID = (int)$entityTypeID;

		if($entityTypeID !== \CCrmOwnerType::Lead
			&& $entityTypeID !== \CCrmOwnerType::Contact
			&& $entityTypeID !== \CCrmOwnerType::Company)
		{
			return array();
		}

		$result = array();
		if($entityTypeID === \CCrmOwnerType::Lead || $entityTypeID === \CCrmOwnerType::Contact)
		{
			$result = array_merge($result, DuplicatePersonCriterion::getSupportedDedupeTypes());
		}
		if($entityTypeID === \CCrmOwnerType::Lead || $entityTypeID === \CCrmOwnerType::Company)
		{
			$result = array_merge($result, DuplicateOrganizationCriterion::getSupportedDedupeTypes());
		}
		$result = array_merge($result, DuplicateCommunicationCriterion::getSupportedDedupeTypes());
		if ($entityTypeID === \CCrmOwnerType::Contact || $entityTypeID === \CCrmOwnerType::Company)
		{
			$result = array_merge(
				$result,
				DuplicateRequisiteCriterion::getSupportedDedupeTypes(),
				DuplicateBankDetailCriterion::getSupportedDedupeTypes()
			);
		}
		return $result;
	}
	public static function parseScopeOption($options)
	{
		$scope = DuplicateIndexType::DEFAULT_SCOPE;
		if (is_array($options))
		{
			if (isset($options['SCOPE']))
			{
				if(!DuplicateIndexType::checkScopeValue($options['SCOPE']))
				{
					throw new Main\ArgumentException("Option has invalid value", 'SCOPE');
				}

				$scope = $options['SCOPE'];
			}
		}

		return $scope;
	}
	public static function getDedupeTypeScopeMap($entityTypeID)
	{
		$result = array();

		$rqFieldScopeMap = $bdFieldScopeMap = null;
		foreach (self::getSupportedDedupeTypes($entityTypeID) as $typeID)
		{
			$isRequisite = (($typeID & DuplicateIndexType::REQUISITE) === $typeID);
			$isBankDetail = (($typeID & DuplicateIndexType::BANK_DETAIL) === $typeID);
			if($isRequisite || $isBankDetail)
			{
				if ($isRequisite)
					$fieldScopeMap = &$rqFieldScopeMap;
				else
					$fieldScopeMap = &$bdFieldScopeMap;
				if ($fieldScopeMap === null)
				{
					$fieldScopeMap = array();
					if ($isRequisite)
						$fieldsMap = DuplicateRequisiteCriterion::getIndexedFieldsMap($entityTypeID, true);
					else
						$fieldsMap = DuplicateBankDetailCriterion::getIndexedFieldsMap($entityTypeID, true);
					foreach ($fieldsMap as $scope => $fields)
					{
						foreach ($fields as $fieldName)
						{
							$fieldScopeMap[DuplicateIndexType::resolveID($fieldName)][$scope] = true;
						}
					}
				}
				$scopes = isset($fieldScopeMap[$typeID]) ? array_keys($fieldScopeMap[$typeID]) : array();
				unset($fieldScopeMap);
			}
			else
			{
				$scopes = array('');
			}
			if (!empty($scopes))
			{
				$result[$typeID] = $scopes;
			}
		}

		return $result;
	}
	public static function prepareEntityListQueries($entityTypeID, array $comparisonData)
	{
		$queries = array();
		foreach($comparisonData as $data)
		{
			$type = $data['TYPE'];
			$matches = $data['MATCHES'];
			$item = self::createCriterion($type, $matches);
			$item->setStrictComparison(isset($data['ENABLE_STRICT_MODE']) && $data['ENABLE_STRICT_MODE'] == true);
			$query = $item->prepareSearchQuery($entityTypeID, array('ENTITY_ID'))->getQuery();
			$queries[] = "({$query})";
		}

		return $queries;
	}
	public static function prepareEntityListFilter(array &$filter, array $comparisonData, $entityTypeID, $entityAlias = '')
	{
		if($entityAlias === '')
		{
			$entityAlias = 'L';
		}

		$queries = array();
		foreach($comparisonData as $data)
		{
			$type = $data['TYPE'];
			$matches = $data['MATCHES'];
			$item = self::createCriterion($type, $matches);
			$item->setStrictComparison(isset($data['ENABLE_STRICT_MODE']) && $data['ENABLE_STRICT_MODE'] == true);
			$query = $item->prepareSearchQuery($entityTypeID, array('ENTITY_ID'))->getQuery();
			$queries[] = "({$query})";
		}

		if(!isset($filter['__JOINS']))
		{
			$filter['__JOINS'] = array();
		}

		$filter['__JOINS'][] = array(
			'TYPE' => 'INNER',
			'SQL' => 'INNER JOIN('.implode("\nUNION\n", $queries).') DP ON DP.ENTITY_ID = '.$entityAlias.'.ID'
		);
	}
}
