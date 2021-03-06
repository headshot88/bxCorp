<?php
namespace Bitrix\Imopenlines\Model;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class UserRelationTable
 * 
 * Fields:
 * <ul>
 * <li> USER_CODE string(255) mandatory
 * <li> USER_ID int optional
 * <li> CHAT_ID int optional
 * <li> AGREES bool optional default 'N'
 * </ul>
 *
 * @package Bitrix\Imopenlines
 *
 * DO NOT WRITE ANYTHING BELOW THIS
 *
 * <<< ORMENTITYANNOTATION
 * @method static EO_UserRelation_Query query()
 * @method static EO_UserRelation_Result getByPrimary($primary, array $parameters = array())
 * @method static EO_UserRelation_Result getById($id)
 * @method static EO_UserRelation_Result getList(array $parameters = array())
 * @method static EO_UserRelation_Entity getEntity()
 * @method static \Bitrix\Imopenlines\Model\EO_UserRelation createObject($setDefaultValues = true)
 * @method static \Bitrix\Imopenlines\Model\EO_UserRelation_Collection createCollection()
 * @method static \Bitrix\Imopenlines\Model\EO_UserRelation wakeUpObject($row)
 * @method static \Bitrix\Imopenlines\Model\EO_UserRelation_Collection wakeUpCollection($rows)
 */

class UserRelationTable extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_imopenlines_user_relation';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			'USER_CODE' => array(
				'data_type' => 'string',
				'primary' => true,
				'validation' => array(__CLASS__, 'validateUserCode'),
			),
			'USER_ID' => array(
				'data_type' => 'integer',
				'default_value' => '0',
			),
			'CHAT_ID' => array(
				'data_type' => 'integer',
				'default_value' => '0',
			),
			'AGREES' => array(
				'data_type' => 'boolean',
				'values' => array('N', 'Y'),
				'default_value' => 'N',
			),
		);
	}
	/**
	 * Returns validators for USER_CODE field.
	 *
	 * @return array
	 */
	public static function validateUserCode()
	{
		return array(
			new Main\Entity\Validator\Length(null, 255),
		);
	}
}