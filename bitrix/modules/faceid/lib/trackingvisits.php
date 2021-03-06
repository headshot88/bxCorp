<?php
/**
 * Bitrix Framework
 * @package    bitrix
 * @subpackage faceid
 * @copyright  2001-2016 Bitrix
 */

namespace Bitrix\Faceid;

use Bitrix\Main,
	Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);

/**
 * Class TrackingVisitsTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> VISITOR_ID int mandatory
 * <li> DATE datetime mandatory
 * </ul>
 *
 * @package Bitrix\Faceid
 *
 * DO NOT WRITE ANYTHING BELOW THIS
 *
 * <<< ORMENTITYANNOTATION
 * @method static EO_TrackingVisits_Query query()
 * @method static EO_TrackingVisits_Result getByPrimary($primary, array $parameters = array())
 * @method static EO_TrackingVisits_Result getById($id)
 * @method static EO_TrackingVisits_Result getList(array $parameters = array())
 * @method static EO_TrackingVisits_Entity getEntity()
 * @method static \Bitrix\Faceid\EO_TrackingVisits createObject($setDefaultValues = true)
 * @method static \Bitrix\Faceid\EO_TrackingVisits_Collection createCollection()
 * @method static \Bitrix\Faceid\EO_TrackingVisits wakeUpObject($row)
 * @method static \Bitrix\Faceid\EO_TrackingVisits_Collection wakeUpCollection($rows)
 */

class TrackingVisitsTable extends Main\Entity\DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_faceid_tracking_visits';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return array(
			new Main\Entity\IntegerField('ID', array(
				'primary' => true,
				'autocomplete' => true
			)),
			new Main\Entity\IntegerField('VISITOR_ID', array(
				'required' => true
			)),
			new Main\Entity\DatetimeField('DATE', array(
				'required' => true
			))
		);
	}

	/**
	 * @param $visitorId
	 *
	 * @return Main\Entity\AddResult
	 */
	public static function registerVisit($visitorId)
	{
		$currentDate = new Main\Type\DateTime;

		$addResult = static::add(array(
			'VISITOR_ID' => $visitorId,
			'DATE' => $currentDate
		));

		if ($addResult->isSuccess())
		{
			TrackingVisitorsTable::update($visitorId, array(
				'PRELAST_VISIT' => new Main\DB\SqlExpression('?#', 'LAST_VISIT'),
				'LAST_VISIT' => $currentDate,
				'LAST_VISIT_ID' => $addResult->getId(),
				'VISITS_COUNT' => new Main\DB\SqlExpression('?# + 1', 'VISITS_COUNT')
			));
		}

		return $addResult;
	}
}