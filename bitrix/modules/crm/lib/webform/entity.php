<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage crm
 * @copyright 2001-2016 Bitrix
 */
namespace Bitrix\Crm\WebForm;

use Bitrix\Crm\Service\Container;
use Bitrix\Main\Localization\Loc;
use Bitrix\Crm\UtmTable;
use Bitrix\Crm\Merger;

Loc::loadMessages(__FILE__);

class Entity
{
	const ENUM_ENTITY_SCHEME_LEAD = 1;
	const ENUM_ENTITY_SCHEME_CONTACT = 2;
	const ENUM_ENTITY_SCHEME_DEAL = 3;
	const ENUM_ENTITY_SCHEME_QUOTE = 4;
	const ENUM_ENTITY_SCHEME_CONTACT_INVOICE = 5;
	const ENUM_ENTITY_SCHEME_DEAL_INVOICE = 6;
	const ENUM_ENTITY_SCHEME_QUOTE_INVOICE = 7;
	const ENUM_ENTITY_SCHEME_LEAD_INVOICE = 8;

	public static function getMap($entityTypeName = null)
	{
		static $invoiceDefaultStatusId = null;
		if ($invoiceDefaultStatusId === null)
		{
			$invoiceDefaultStatusId = \CAllCrmInvoice::getDefaultStatusId();
		}

		$entityTypeMap =  array(
			\CCrmOwnerType::LeadName => array(
				'CLASS_NAME' => 'CCrmLead',
				'DUPLICATE_CHECK' => array(
					'CHECKER_CLASS_NAME' => '\Bitrix\Crm\Integrity\LeadDuplicateChecker',
					'MERGER_CLASS_NAME' => Merger\LeadMerger::class,
				),
				'HAS_MULTI_FIELDS' => true,
				'FIELD_AUTO_FILL_TEMPLATE' => array(
					'TITLE' => array(
						'TEMPLATE' => Loc::getMessage('CRM_WEBFORM_ENTITY_FIELD_NAME_TEMPLATE'),
					),
					'OPENED' => array(
						'TEMPLATE' => 'Y'
					),
					'SOURCE_ID' => array(
						'TEMPLATE' => 'WEBFORM'
					)
				)
			),
			\CCrmOwnerType::ContactName => array(
				'CLASS_NAME' => 'CCrmContact',
				'DUPLICATE_CHECK' => array(
					'CHECKER_CLASS_NAME' => '\Bitrix\Crm\Integrity\ContactDuplicateChecker',
					'MERGER_CLASS_NAME' => Merger\ContactMerger::class,
				),
				'HAS_MULTI_FIELDS' => true,
				'FIELD_AUTO_FILL_TEMPLATE' => array(
					'NAME' => array(
						'TEMPLATE' => Loc::getMessage('CRM_WEBFORM_ENTITY_FIELD_NAME_CONTACT_TEMPLATE'),
					),
					'OPENED' => array(
						'TEMPLATE' => 'Y'
					),
					'EXPORT' => array(
						'TEMPLATE' => 'Y'
					),
					'SOURCE_ID' => array(
						'TEMPLATE' => 'WEBFORM'
					)
				),
				'EXCLUDED_FIELDS' => array()
			),
			\CCrmOwnerType::CompanyName => array(
				'CLASS_NAME' => 'CCrmCompany',
				'DUPLICATE_CHECK' => array(
					'CHECKER_CLASS_NAME' => '\Bitrix\Crm\Integrity\CompanyDuplicateChecker',
					'MERGER_CLASS_NAME' => Merger\CompanyMerger::class,
				),
				'HAS_MULTI_FIELDS' => true,
				'FIELD_AUTO_FILL_TEMPLATE' => array(
					'TITLE' => array(
						'TEMPLATE' => Loc::getMessage('CRM_WEBFORM_ENTITY_FIELD_NAME_COMPANY_TEMPLATE'),
					),
					'OPENED' => array(
						'TEMPLATE' => 'Y'
					)
				)
			),
			\CCrmOwnerType::DealName => array(
				'CLASS_NAME' => 'CCrmDeal',
				'DUPLICATE_CHECK' => array(
					'CHECKER_CLASS_NAME' => null,
					'MERGER_CLASS_NAME' => Merger\DealMerger::class,
				),
				'FIELD_AUTO_FILL_TEMPLATE' => array(
					'TITLE' => array(
						'TEMPLATE' => Loc::getMessage('CRM_WEBFORM_ENTITY_FIELD_NAME_TEMPLATE'),
					),
					'OPENED' => array(
						'TEMPLATE' => 'Y'
					),
					'SOURCE_ID' => array(
						'TEMPLATE' => 'WEBFORM'
					)
				)
			),
			\CCrmOwnerType::QuoteName => array(
				'CLASS_NAME' => 'CCrmQuote',
				'FIELD_AUTO_FILL_TEMPLATE' => array(
					'TITLE' => array(
						'TEMPLATE' => Loc::getMessage('CRM_WEBFORM_ENTITY_FIELD_NAME_TEMPLATE'),
					),
					'OPENED' => array(
						'TEMPLATE' => 'Y'
					)
				)
			),
			\CCrmOwnerType::InvoiceName => array(
				'CLASS_NAME' => 'CCrmInvoice',
				'FIELD_AUTO_FILL_TEMPLATE' => array(
					'ORDER_TOPIC' => array(
						'TEMPLATE' => Loc::getMessage('CRM_WEBFORM_ENTITY_FIELD_NAME_TEMPLATE'),
					),
					'STATUS_ID' => array(
						'TEMPLATE' => $invoiceDefaultStatusId,
					),
				)
			),
		);

		$entityTypeMap += self::getDynamicMap();

		if($entityTypeName)
		{
			return $entityTypeMap[$entityTypeName];
		}
		else
		{
			return $entityTypeMap;
		}
	}

	/**
	 * Get dynamic entity map.
	 *
	 * @return array|null
	 * @throws \Bitrix\Main\InvalidOperationException
	 */
	public static function getDynamicMap()
	{
		static $dynamicTypeMap = null;
		if ($dynamicTypeMap !== null)
		{
			return $dynamicTypeMap;
		}

		$dynamicTypeMap = [];
		foreach (Container::getInstance()->getDynamicTypesMap()->load()->getTypes() as $type)
		{
			$dynamicTypeMap[\CCrmOwnerType::resolveName($type->getEntityTypeId())] = array(
				'GET_FIELDS_CALL' => function () use ($type) {
					$factory = Container::getInstance()->getFactory($type->getEntityTypeId());
					return $factory
						? array_merge($factory->getFieldsInfo(), $factory->getUserFieldsInfo())
						: []
					;
				},
				'CLEAR_FIELDS_CACHE_CALL' => function () use ($type) {
					$factory = Container::getInstance()->getFactory($type->getEntityTypeId());
					if ($factory)
					{
						$factory->clearUserFieldsInfoCache();
					}
				},
				'GET_FIELD_CAPTION' => function ($fieldName) use ($type) {
					$factory = Container::getInstance()->getFactory($type->getEntityTypeId());
					return $factory
						? $factory->getFieldCaption($fieldName)
						: null
					;
				},
				'FIELD_AUTO_FILL_TEMPLATE' => array(
					'TITLE' => array(
						'TEMPLATE' => Loc::getMessage('CRM_WEBFORM_ENTITY_FIELD_NAME_TEMPLATE'),
					),
				),
				'DUPLICATE_CHECK' => array(
					'CHECKER_CLASS_NAME' => null,
					'MERGER_CLASS_NAME' => Merger\DealMerger::class, // real is anonymus class
				),
			);
		}

		return $dynamicTypeMap;
	}

	public static function getCommonExcludedFieldCodes()
	{
		return array(
			'INVOICE_STATUS_ID',
			'QUOTE_CLIENT_EMAIL',
			'QUOTE_CLIENT_PHONE',
			'QUOTE_CLIENT_TPA_ID',
			'QUOTE_CLIENT_TP_ID',
			'QUOTE_CLIENT_CONTACT',
			'QUOTE_CLIENT_ADDR',
			'QUOTE_CLIENT_TITLE',
			'QUOTE_MYCOMPANY_ID',
		);
	}

	public static function getEntityMapCommonExcludedFields()
	{
		$fieldCodes = array(
			'ASSIGNED_BY_ID',

			//'PROBABILITY', 'DATE_PAY_BEFORE',
			'REVENUE',
			'OPPORTUNITY',

			// DYNAMIC
			'MYCOMPANY_ID', 'CONTACTS', 'OBSERVERS',

			//LEAD
			'CURRENCY_ID', 'OPENED', 'COMPANY_ID', 'CONTACT_ID',
			'CLOSED', 'EXPORT', 'BANKING_DETAILS', 'DEAL_ID', 'PERSON_TYPE_ID',

			//INVOICE
			'ACCOUNT_NUMBER', 'CURRENCY', 'DATE_BILL', 'DATE_MARKED',
			'PAY_SYSTEM_ID', 'RESPONSIBLE_ID', 'UF_DEAL_ID', 'UF_CONTACT_ID', 'PR_LOCATION',

			//DEAL
			'CONTACT_IDS', 'LOCATION_ID', 'LEAD_ID', 'CREATED_BY_ID', 'QUOTE_ID', 'OBSERVER_IDS', 'FACE_ID', 'CATEGORY_ID',

			'ADDRESS_LEGAL',

			//'ADDRESS', 'REG_ADDRESS',
			'ADDRESS_2', 'ADDRESS_CITY', 'ADDRESS_POSTAL_CODE', 'ADDRESS_REGION',
			'ADDRESS_PROVINCE', 'ADDRESS_COUNTRY', 'ADDRESS_COUNTRY_CODE',
			'REG_ADDRESS_2', 'REG_ADDRESS_CITY', 'REG_ADDRESS_POSTAL_CODE', 'REG_ADDRESS_REGION',
			'REG_ADDRESS_PROVINCE', 'REG_ADDRESS_COUNTRY', 'REG_ADDRESS_COUNTRY_CODE',

			'ORIGIN_ID', 'ORIGINATOR_ID', 'ADDRESS_LOC_ADDR_ID', 'REG_ADDRESS_LOC_ADDR_ID',

			'MOVED_BY', 'MOVED_BY_ID', 'MOVED_TIME',
		);

		$fieldCodes = array_merge($fieldCodes, UtmTable::getCodeList());

		return $fieldCodes;
	}

	public static function getSchemesCodes()
	{
		$result = array();
		foreach(self::getSchemes() as $code => $value)
		{
			$result[] = (string) $code;
		}

		return $result;
	}

	public static function getSchemesByInvoice($selectedSchemeId = null, $allowedEntitySchemes = null)
	{
		$result = array(
			'HAS_DEAL' => false,
			'HAS_DYNAMIC' => false,
			'HAS_INVOICE' => false,
			'SELECTED_DESCRIPTION' => '',
			'BY_INVOICE' => array(),
			'BY_NON_INVOICE' => array(),
		);
		$schemes = self::getSchemes();
		$previousSchemeId = null;
		foreach($schemes as $schemeId => $scheme)
		{
			if(!$selectedSchemeId)
			{
				$selectedSchemeId = $schemeId;
			}

			$scheme['ID'] = $schemeId;
			$scheme['SELECTED'] = false;
			$scheme['DISABLED'] = (!empty($allowedEntitySchemes) && !in_array($schemeId, $allowedEntitySchemes));

			$hasDeal = in_array(\CCrmOwnerType::DealName, $scheme['ENTITIES']);
			$hasInvoice = in_array(\CCrmOwnerType::InvoiceName, $scheme['ENTITIES']);
			$searchSchemeId = $hasInvoice ? $previousSchemeId : $schemeId;

			$section = $hasInvoice ? 'BY_INVOICE' : 'BY_NON_INVOICE';
			$result[$section][$searchSchemeId] = $scheme;
			$previousSchemeId = $schemeId;

			if($schemeId == $selectedSchemeId)
			{
				$result['SELECTED_ID'] = $selectedSchemeId;
				$result['HAS_DEAL'] = $hasDeal;
				$result['HAS_INVOICE'] = $hasInvoice;
				$result['HAS_DYNAMIC'] = $scheme['DYNAMIC'];
				$result['BY_NON_INVOICE'][$searchSchemeId]['SELECTED'] = true;
				$result['SELECTED_DESCRIPTION'] = $scheme['DESCRIPTION'];
			}
		}

		return $result;
	}

	/**
	 * Get schemes
	 *
	 * @param int|null $schemeId Scheme ID.
	 * @return array|array[]
	 */
	public static function getSchemes($schemeId = null)
	{
		// ATTENTION!!! SCHEME ORDER IS IMPORTANT FOR getSchemesByInvoice
		// ATTENTION!!! ENTITY ORDER IS IMPORTANT FOR SYNCHRONIZATION
		static $schemes = null;
		if ($schemes !== null)
		{
			return $schemeId ? ($schemes[$schemeId] ?? null) : $schemes;
		}

		$schemes = array(
			self::ENUM_ENTITY_SCHEME_LEAD => array(
				'NAME' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_LEED'),
				'ENTITIES' => array(
					\CCrmOwnerType::LeadName,
					\CCrmOwnerType::CompanyName,
					\CCrmOwnerType::ContactName
				),
				'MAIN_ENTITY' => \CCrmOwnerType::Lead,
				'HAS_INVOICE' => false,
				'DYNAMIC' => false,
				'DESCRIPTION' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_LEED_DESC')
			),
			self::ENUM_ENTITY_SCHEME_LEAD_INVOICE => array(
				'NAME' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_LEED'),
				'ENTITIES' => array(
					\CCrmOwnerType::InvoiceName,
					\CCrmOwnerType::LeadName,
					\CCrmOwnerType::CompanyName,
					\CCrmOwnerType::ContactName
				),
				'MAIN_ENTITY' => \CCrmOwnerType::Lead,
				'HAS_INVOICE' => true,
				'DYNAMIC' => false,
				'DESCRIPTION' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_LEED_INVOICE_DESC1')
			),
			self::ENUM_ENTITY_SCHEME_CONTACT => array(
				'NAME' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_CLIENT'),
				'ENTITIES' => array(
					\CCrmOwnerType::ContactName,
					\CCrmOwnerType::CompanyName,
				),
				'MAIN_ENTITY' => null,
				'HAS_INVOICE' => false,
				'DYNAMIC' => false,
				'DESCRIPTION' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_CLIENT_DESC')
			),
			self::ENUM_ENTITY_SCHEME_CONTACT_INVOICE => array(
				'NAME' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_CLIENT'),
				'ENTITIES' => array(
					\CCrmOwnerType::InvoiceName,
					\CCrmOwnerType::CompanyName,
					\CCrmOwnerType::ContactName,
				),
				'MAIN_ENTITY' => null,
				'HAS_INVOICE' => true,
				'DYNAMIC' => false,
				'DESCRIPTION' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_CLIENT_INVOICE_DESC1')
			),
			self::ENUM_ENTITY_SCHEME_DEAL => array(
				'NAME' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_DEAL'),
				'ENTITIES' => array(
					\CCrmOwnerType::DealName,
					\CCrmOwnerType::CompanyName,
					\CCrmOwnerType::ContactName,
				),
				'MAIN_ENTITY' => \CCrmOwnerType::Deal,
				'HAS_INVOICE' => false,
				'DYNAMIC' => false,
				'DESCRIPTION' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_DEAL_DESC')
			),
			self::ENUM_ENTITY_SCHEME_DEAL_INVOICE => array(
				'NAME' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_DEAL'),
				'ENTITIES' => array(
					\CCrmOwnerType::InvoiceName,
					\CCrmOwnerType::DealName,
					\CCrmOwnerType::CompanyName,
					\CCrmOwnerType::ContactName,
				),
				'MAIN_ENTITY' => \CCrmOwnerType::Deal,
				'HAS_INVOICE' => true,
				'DYNAMIC' => false,
				'DESCRIPTION' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_DEAL_INVOICE_DESC1')
			),
			self::ENUM_ENTITY_SCHEME_QUOTE => array(
				'NAME' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_QUOTE'),
				'ENTITIES' => array(
					\CCrmOwnerType::QuoteName,
					\CCrmOwnerType::CompanyName,
					\CCrmOwnerType::ContactName,
				),
				'MAIN_ENTITY' => \CCrmOwnerType::Quote,
				'HAS_INVOICE' => false,
				'DYNAMIC' => false,
				'DESCRIPTION' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_QUOTE_DESC')
			),
			self::ENUM_ENTITY_SCHEME_QUOTE_INVOICE => array(
				'NAME' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_QUOTE'),
				'ENTITIES' => array(
					\CCrmOwnerType::InvoiceName,
					\CCrmOwnerType::QuoteName,
					\CCrmOwnerType::CompanyName,
					\CCrmOwnerType::ContactName,
				),
				'MAIN_ENTITY' => \CCrmOwnerType::Quote,
				'HAS_INVOICE' => true,
				'DYNAMIC' => false,
				'DESCRIPTION' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_QUOTE_INVOICE_DESC1')
			),
		);

		foreach (Container::getInstance()->getDynamicTypesMap()->load()->getTypes() as $type)
		{
			$entityTypeName = \CCrmOwnerType::resolveName($type->getEntityTypeId());
			$schemes[$type->getEntityTypeId() * 10] = [
				'NAME' => $type->getTitle(),
				'ENTITIES' => [
					$entityTypeName,
					\CCrmOwnerType::CompanyName,
					\CCrmOwnerType::ContactName,
				],
				'MAIN_ENTITY' => $type->getEntityTypeId(),
				'HAS_INVOICE' => false,
				'DYNAMIC' => true,
				'DESCRIPTION' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_DYNAMIC_DESC')
			];

			$schemes[$type->getEntityTypeId() * 10 + 1] = [
				'NAME' => $type->getTitle(),
				'ENTITIES' => [
					\CCrmOwnerType::InvoiceName,
					$entityTypeName,
					\CCrmOwnerType::CompanyName,
					\CCrmOwnerType::ContactName,
				],
				'MAIN_ENTITY' => $type->getEntityTypeId(),
				'HAS_INVOICE' => true,
				'DYNAMIC' => true,
				'DESCRIPTION' => Loc::getMessage('CRM_WEBFORM_ENTITY_SCHEME_DYNAMIC_INVOICE_DESC')
			];
		}

		if($schemeId)
		{
			return $schemes[$schemeId] ?? null;
		}
		else
		{
			return $schemes;
		}
	}

	/**
	 * Return true if scheme support entity.
	 *
	 * @param int $schemeId Scheme ID.
	 * @param int $entityTypeId Entity type ID.
	 * @return bool
	 */
	public static function isSchemeSupportEntity(int $schemeId, int $entityTypeId): bool
	{
		$scheme = Entity::getSchemes((int) $schemeId);
		$entityName = \CCrmOwnerType::ResolveName((int) $entityTypeId);

		return (
			$entityName && $scheme
			&& in_array($entityName, $scheme['ENTITIES'], true));
	}

	public static function getNames()
	{
		return array_keys(static::getList());
	}

	public static function getList()
	{
		$result = array();
		$map = static::getMap();
		foreach($map as $entityName => $entity)
		{
			$entityId = \CCrmOwnerType::ResolveID($entityName);
			if ($entityId === \CCrmOwnerType::Invoice)
			{
				$entityId = \CCrmOwnerType::Order;
			}
			$result[$entityName] = \CCrmOwnerType::GetDescription($entityId);
		}

		return $result;
	}

	public static function getFieldCaption($entityName, $fieldId)
	{
		static $map = null;
		if ($map === null)
		{
			$map = static::getMap();
		}

		$entity = $map[$entityName];
		if (isset($entity['GET_FIELD_CAPTION']))
		{
			return $entity['GET_FIELD_CAPTION']($fieldId);
		}

		/**@var $className \CCrmLead*/
		$className = $entity['CLASS_NAME'];
		return $className::GetFieldCaption($fieldId);
	}

	public static function getDefaultFieldsInfoMethod()
	{
		return 'GetFieldsInfo';
	}
}