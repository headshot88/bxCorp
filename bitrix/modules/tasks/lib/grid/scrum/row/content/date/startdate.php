<?php
namespace Bitrix\Tasks\Grid\Scrum\Row\Content\Date;

use Bitrix\Tasks\Grid\Scrum\Row\Content\Date;

/**
 * Class StartDate
 *
 * @package Bitrix\Tasks\Grid\Scrum\Row\Content\Date
 */
class StartDate extends Date
{
	public function prepare(): string
	{
		$row = $this->getRowData();
		$startDate = ($row['PROJECT_DATE_START'] ?: false);

		return $this->formatDate($startDate);
	}
}