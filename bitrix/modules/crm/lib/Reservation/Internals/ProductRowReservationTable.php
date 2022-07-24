<?php
namespace Bitrix\Crm\Reservation\Internals;

use Bitrix\Crm\ProductRowTable;
use Bitrix\Main\Application;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\DataManager;
use Bitrix\Main\ORM\Fields\BooleanField;
use Bitrix\Main\ORM\Fields\DateField;
use Bitrix\Main\ORM\Fields\IntegerField;
use Bitrix\Main\ORM\Fields\FloatField;
use Bitrix\Main\ORM\Fields\Relations\Reference;
use Bitrix\Main\ORM\Query\Join;

/**
 * Class ProductRowReservationTable
 *
 * Fields:
 * <ul>
 * <li> ID int mandatory
 * <li> PRODUCT_ROW_ID int mandatory
 * <li> BASKET_RESERVATION_ID int mandatory
 * </ul>
 *
 * @package Bitrix\Crm\Reservation\Internals
 **/
class ProductRowReservationTable extends DataManager
{
	/**
	 * Returns DB table name for entity.
	 *
	 * @return string
	 */
	public static function getTableName()
	{
		return 'b_crm_product_row_reservation';
	}

	/**
	 * Returns entity map definition.
	 *
	 * @return array
	 */
	public static function getMap()
	{
		return [
			new IntegerField(
				'ID',
				[
					'primary' => true,
					'autocomplete' => true,
					'title' => Loc::getMessage('PRODUCT_ROW_RESERVE_ENTITY_ID_FIELD'),
				]
			),
			new IntegerField(
				'ROW_ID',
				[
					'required' => true,
					'title' => Loc::getMessage('PRODUCT_ROW_RESERVE_ENTITY_PRODUCT_ROW_ID_FIELD'),
				]
			),
			new FloatField(
				'RESERVE_QUANTITY',
				[
					'title' => Loc::getMessage('PRODUCT_ROW_RESERVE_ENTITY_BASKET_RESERVATION_ID_FIELD'),
				]
			),
			new DateField(
				'DATE_RESERVE_END',
				[
					'title' => Loc::getMessage('PRODUCT_ROW_RESERVE_ENTITY_DATE_RESERVE_END'),
				]
			),
			new IntegerField(
				'STORE_ID',
				[
					'title' => Loc::getMessage('PRODUCT_ROW_RESERVE_ENTITY_BASKET_RESERVATION_ID_FIELD'),
				]
			),
			new BooleanField(
				'IS_AUTO',
				[
					'default_value' => null,
					'values' => ['N', 'Y'],
				]
			),
			//
			new Reference(
				'ROW',
				ProductRowTable::class,
				Join::on('this.ROW_ID', 'ref.ID')
			),
		];
	}

	/**
	 * Get reserve by product row id.
	 *
	 * @param int $rowId
	 *
	 * @return array|null
	 */
	public static function getRowByRowId(int $rowId): ?array
	{
		return static::getRow([
			'filter' => [
				'=ROW_ID' => $rowId,
			],
		]);
	}

	public static function deleteByRowId($rowId)
	{
		$sql = new \Bitrix\Main\DB\SqlExpression(
			"DELETE FROM ?# WHERE ROW_ID = ?i",
			static::getTableName(),
			$rowId
		);
		Application::getConnection(static::getConnectionName())->query($sql);
	}
}
