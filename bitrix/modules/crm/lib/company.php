<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage crm
 * @copyright 2001-2012 Bitrix
 */
namespace Bitrix\Crm;

use Bitrix\Crm\Service\Container;
use Bitrix\Main\Entity;
use Bitrix\Main\Entity\IntegerField;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Fields\Relations\CascadePolicy;
use Bitrix\Main\ORM\Fields\Relations\OneToMany;
use Bitrix\Main\ORM\Fields\StringField;

Loc::loadMessages(__FILE__);

/**
 * Class CompanyTable
 *
 * DO NOT WRITE ANYTHING BELOW THIS
 *
 * <<< ORMENTITYANNOTATION
 * @method static EO_Company_Query query()
 * @method static EO_Company_Result getByPrimary($primary, array $parameters = array())
 * @method static EO_Company_Result getById($id)
 * @method static EO_Company_Result getList(array $parameters = array())
 * @method static EO_Company_Entity getEntity()
 * @method static \Bitrix\Crm\EO_Company createObject($setDefaultValues = true)
 * @method static \Bitrix\Crm\EO_Company_Collection createCollection()
 * @method static \Bitrix\Crm\EO_Company wakeUpObject($row)
 * @method static \Bitrix\Crm\EO_Company_Collection wakeUpCollection($rows)
 */
class CompanyTable extends Entity\DataManager
{
	protected static $isCheckUserFields = true;

	public static function getTableName()
	{
		return 'b_crm_company';
	}

	public static function getUFId()
	{
		return 'CRM_COMPANY';
	}

	public static function getMap()
	{
		Container::getInstance()->getLocalization()->loadMessages();

		global $DB;

		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
			),
			'TITLE' => array(
				'data_type' => 'string'
			),
			(new StringField('LOGO'))->configureSize(10),
			'COMPANY_TYPE' => array(
				'data_type' => 'string'
			),
			'COMPANY_TYPE_BY' => array(
				'data_type' => 'Status',
				'reference' => array(
					'=this.COMPANY_TYPE' => 'ref.STATUS_ID',
					'=ref.ENTITY_ID' => array('?', 'COMPANY_TYPE')
				)
			),
			'INDUSTRY' => array(
				'data_type' => 'string'
			),
			'INDUSTRY_BY' => array(
				'data_type' => 'Status',
				'reference' => array(
					'=this.INDUSTRY' => 'ref.STATUS_ID',
					'=ref.ENTITY_ID' => array('?', 'INDUSTRY')
				)
			),
			'EMPLOYEES' => array(
				'data_type' => 'string'
			),
			'EMPLOYEES_BY' => array(
				'data_type' => 'Status',
				'reference' => array(
					'=this.EMPLOYEES' => 'ref.STATUS_ID',
					'=ref.ENTITY_ID' => array('?', 'EMPLOYEES')
				)
			),
			'REVENUE' => array(
				'data_type' => 'string'
			),
//			'REVENUE_BY' => array( // FOR COMPATIBILITY ONLY
//				'data_type' => 'CrmStatus',
//				'reference' => array('=this.REVENUE' => 'ref.STATUS_ID')
//			),
			'CURRENCY_ID' => array(
				'data_type' => 'string'
			),
//			'CURRENCY_BY' => array(
//				'data_type' => 'CrmStatus',
//				'reference' => array('CURRENCY_ID', 'STATUS_ID')
//			),
			'COMMENTS' => array(
				'data_type' => 'string'
			),
			'OPENED' => array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y')
			),
			'ADDRESS' => array(
				'data_type' => 'string'
			),
			'ADDRESS_LEGAL' => array(
				'data_type' => 'string'
			),
			'BANKING_DETAILS' => array(
				'data_type' => 'string'
			),
			'DATE_CREATE' => array(
				'data_type' => 'datetime'
			),
			'DATE_MODIFY' => array(
				'data_type' => 'datetime'
			),
			'ASSIGNED_BY_ID' => array(
				'data_type' => 'integer'
			),
			'ASSIGNED_BY' => array(
				'data_type' => 'Bitrix\Main\User',
				'reference' => array('=this.ASSIGNED_BY_ID' => 'ref.ID')
			),
			'CREATED_BY_ID' => array(
				'data_type' => 'integer'
			),
			'CREATED_BY' => array(
				'data_type' => 'Bitrix\Main\User',
				'reference' => array('=this.CREATED_BY_ID' => 'ref.ID')
			),
			'MODIFY_BY_ID' => array(
				'data_type' => 'integer'
			),
			'MODIFY_BY' => array(
				'data_type' => 'Bitrix\Main\User',
				'reference' => array('=this.MODIFY_BY_ID' => 'ref.ID')
			),
			'EVENT_RELATION' => array(
				'data_type' => 'EventRelations',
				'reference' => array('=this.ID' => 'ref.ENTITY_ID')
			),
			'LEAD_ID' => array(
				'data_type' => 'integer'
			),
			'IS_MY_COMPANY' => array(
				'data_type' => 'string'
			),
			'HAS_EMAIL' => array(
				'data_type' => 'boolean',
				'default_value' => 'N',
				'values' => array('N', 'Y')
			),
			'HAS_PHONE' => array(
				'data_type' => 'boolean',
				'default_value' => 'N',
				'values' => array('N', 'Y')
			),
			'HAS_IMOL' => array(
				'data_type' => 'boolean',
				'default_value' => 'N',
				'values' => array('N', 'Y')
			),
			'EMAIL_HOME' => array(
				'data_type' => 'string',
				'expression' => array(
					'('.$DB->TopSql(
						'SELECT FM.VALUE '.
						'FROM b_crm_field_multi FM '.
						'WHERE FM.ENTITY_ID = \'COMPANY\' '.
						'AND FM.ELEMENT_ID = %s '.
						'AND FM.TYPE_ID = \'EMAIL\' '.
						'AND FM.VALUE_TYPE = \'HOME\' '.
						'ORDER BY FM.ID', 1
					).')',
					'ID'
				)
			),
			'EMAIL_WORK' => array(
				'data_type' => 'string',
				'expression' => array(
					'('.$DB->TopSql(
						'SELECT FM.VALUE '.
						'FROM b_crm_field_multi FM '.
						'WHERE FM.ENTITY_ID = \'COMPANY\' '.
						'AND FM.ELEMENT_ID = %s '.
						'AND FM.TYPE_ID = \'EMAIL\' '.
						'AND FM.VALUE_TYPE = \'WORK\' '.
						'ORDER BY FM.ID', 1
					).')',
					'ID'
				)
			),
			'EMAIL_MAILING' => array(
				'data_type' => 'string',
				'expression' => array(
					'('.$DB->TopSql(
						'SELECT FM.VALUE '.
						'FROM b_crm_field_multi FM '.
						'WHERE FM.ENTITY_ID = \'COMPANY\' '.
						'AND FM.ELEMENT_ID = %s '.
						'AND FM.TYPE_ID = \'EMAIL\' '.
						'AND FM.VALUE_TYPE = \'MAILING\' '.
						'ORDER BY FM.ID', 1
					).')',
					'ID'
				)
			),
			'PHONE_MOBILE' => array(
				'data_type' => 'string',
				'expression' => array(
					'('.$DB->TopSql(
						'SELECT FM.VALUE '.
						'FROM b_crm_field_multi FM '.
						'WHERE FM.ENTITY_ID = \'COMPANY\' '.
						'AND FM.ELEMENT_ID = %s '.
						'AND FM.TYPE_ID = \'PHONE\' '.
						'AND FM.VALUE_TYPE = \'MOBILE\' '.
						'ORDER BY FM.ID', 1
					).')',
					'ID'
				)
			),
			'PHONE_WORK' => array(
				'data_type' => 'string',
				'expression' => array(
					'('.$DB->TopSql(
						'SELECT FM.VALUE '.
						'FROM b_crm_field_multi FM '.
						'WHERE FM.ENTITY_ID = \'COMPANY\' '.
						'AND FM.ELEMENT_ID = %s '.
						'AND FM.TYPE_ID = \'PHONE\' '.
						'AND FM.VALUE_TYPE = \'WORK\' '.
						'ORDER BY FM.ID', 1
					).')',
					'ID'
				)
			),
			'PHONE_MAILING' => array(
				'data_type' => 'string',
				'expression' => array(
					'('.$DB->TopSql(
						'SELECT FM.VALUE '.
						'FROM b_crm_field_multi FM '.
						'WHERE FM.ENTITY_ID = \'COMPANY\' '.
						'AND FM.ELEMENT_ID = %s '.
						'AND FM.TYPE_ID = \'PHONE\' '.
						'AND FM.VALUE_TYPE = \'MAILING\' '.
						'ORDER BY FM.ID', 1
					).')',
					'ID'
				)
			),
			'IMOL' => array(
				'data_type' => 'string',
				'expression' => array(
					'('.$DB->TopSql(
						'SELECT FM.VALUE '.
						'FROM b_crm_field_multi FM '.
						'WHERE FM.ENTITY_ID = \'COMPANY\' '.
						'AND FM.ELEMENT_ID = %s '.
						'AND FM.TYPE_ID = \'IM\' '.
						'AND FM.VALUE LIKE \'imol|%%\' '.
						'ORDER BY FM.ID', 1
					).')',
					'ID'
				)
			),

			'EMAIL' => array(
				'data_type' => 'string',
				'expression' => array(
					'('.$DB->TopSql(
						'SELECT FM.VALUE '.
						'FROM b_crm_field_multi FM '.
						'WHERE FM.ENTITY_ID = \'COMPANY\' '.
						'AND FM.ELEMENT_ID = %s '.
						'AND FM.TYPE_ID = \'EMAIL\' '.
						'ORDER BY FM.ID', 1
					).')',
					'ID'
				)
			),
			'PHONE' => array(
				'data_type' => 'string',
				'expression' => array(
					'('.$DB->TopSql(
						'SELECT FM.VALUE '.
						'FROM b_crm_field_multi FM '.
						'WHERE FM.ENTITY_ID = \'COMPANY\' '.
						'AND FM.ELEMENT_ID = %s '.
						'AND FM.TYPE_ID = \'PHONE\' '.
						'ORDER BY FM.ID', 1
					).')',
					'ID'
				)
			),
			'SEARCH_CONTENT' => array(
				'data_type' => 'string'
			),
			(new IntegerField('CATEGORY_ID'))
				->configureDefaultValue([static::class, 'getDefaultCategoryId'])
				->configureTitle(Loc::getMessage('CRM_COMMON_CLIENT_CATEGORY'))
		,
			(new OneToMany('CONTACT_BINDINGS', Binding\ContactCompanyTable::class, 'COMPANY'))
				->configureCascadeDeletePolicy(CascadePolicy::FOLLOW),
		);
	}

	public static function getDefaultCategoryId(): ?int
	{
		$factory = static::getFactory();

		if($factory)
		{
			$category = static::getFactory()->getDefaultCategory();

			return $category ? $category->getId() : null;
		}

		return null;
	}

	public static function disableUserFieldsCheck(): void
	{
		static::$isCheckUserFields = false;
	}

	protected static function checkUfFields($object, $ufdata, $result)
	{
		if (!static::$isCheckUserFields)
		{
			static::$isCheckUserFields = true;
			return;
		}

		parent::checkUfFields($object, $ufdata, $result);
	}

	protected static function getEntityTypeId(): int
	{
		return \CCrmOwnerType::Company;
	}

	protected static function getFactory(): \Bitrix\Crm\Service\Factory
	{
		return Container::getInstance()->getFactory(static::getEntityTypeId());
	}
}
