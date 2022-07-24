<?php

namespace Bitrix\Crm\Integration\Report\Dashboard\MyReports;

use Bitrix\Crm\Integration\Report\View\MyReports\ActivityReport;
use Bitrix\Main\Localization\Loc;
use Bitrix\Report\VisualConstructor\Entity\Dashboard;
use Bitrix\Report\VisualConstructor\Entity\DashboardRow;
use Bitrix\Report\VisualConstructor\Entity\Widget;
use Bitrix\Report\VisualConstructor\Handler\BaseWidget;
use Bitrix\Report\VisualConstructor\Handler\EmptyReport;
use Bitrix\Report\VisualConstructor\Helper\Util;

Loc::loadMessages(__FILE__);

class ActivityBoard
{
	const VERSION = 'v2';
	const BOARD_KEY = 'crm-vc-myreports-activity';

	public static function getPanelGuid()
	{
		return 'activity_widget';
	}

	/**
	 * @return Dashboard
	 */
	public static function get()
	{
		$board = new Dashboard();
		$board->setVersion(self::VERSION);
		$board->setBoardKey(self::BOARD_KEY);
		$board->setGId(Util::generateUserUniqueId());
		$board->setUserId(0);

		$firstRow = DashboardRow::factoryWithHorizontalCells(1);
		$firstRow->setWeight(1);
		$widget = static::buildWidget();
		$widget->setWeight($firstRow->getLayoutMap()['elements'][0]['id']);
		$firstRow->addWidgets($widget);
		$board->addRows($firstRow);

		return $board;
	}

	/**
	 * @return Widget
	 */
	private static function buildWidget()
	{
		$widget = new Widget();
		$widget->setGId(Util::generateUserUniqueId());
		$widget->setWidgetClass(BaseWidget::getClassName());
		$widget->setViewKey(ActivityReport::VIEW_KEY);
		$widget->setCategoryKey('crm');
		$widget->setBoardId(self::BOARD_KEY);

		$widget->addConfigurations($widget->getWidgetHandler(true)->getConfigurations());

		return $widget;
	}
}