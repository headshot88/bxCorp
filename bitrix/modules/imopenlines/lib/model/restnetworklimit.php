<?php
namespace Bitrix\Imopenlines\Model;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class RestNetworkLimitTable
 * 
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> BOT_ID int mandatory
 * <li> USER_ID int mandatory
 * <li> DATE_CREATE datetime optional
 * </ul>
 *
 * @package Bitrix\Imopenlines
 *
 * DO NOT WRITE ANYTHING BELOW THIS
 *
 * <<< ORMENTITYANNOTATION
 * @method static EO_RestNetworkLimit_Query query()
 * @method static EO_RestNetworkLimit_Result getByPrimary($primary, array $parameters = array())
 * @method static EO_RestNetworkLimit_Result getById($id)
 * @method static EO_RestNetworkLimit_Result getList(array $parameters = array())
 * @method static EO_RestNetworkLimit_Entity getEntity()
 * @method static \Bitrix\Imopenlines\Model\EO_RestNetworkLimit createObject($setDefaultValues = true)
 * @method static \Bitrix\Imopenlines\Model\EO_RestNetworkLimit_Collection createCollection()
 * @method static \Bitrix\Imopenlines\Model\EO_RestNetworkLimit wakeUpObject($row)
 * @method static \Bitrix\Imopenlines\Model\EO_RestNetworkLimit_Collection wakeUpCollection($rows)
 */

class RestNetworkLimitTable extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_imopenlines_rest_network_limit';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			'ID' => array(
				'data_type' => 'integer',
				'primary' => true,
				'autocomplete' => true,
			),
			'BOT_ID' => array(
				'data_type' => 'integer',
				'required' => true,
			),
			'USER_ID' => array(
				'data_type' => 'integer',
				'required' => true,
			),
			'DATE_CREATE' => array(
				'data_type' => 'datetime',
				'default_value' => array(__CLASS__, 'getCurrentDate'),
			),
		);
	}
	
	
	/**
	 * Return current date for DATE_CREATE field.
	 *
	 * @return array
	 */
	public static function getCurrentDate()
	{
		return new \Bitrix\Main\Type\DateTime();
	}
}