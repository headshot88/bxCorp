<?php
namespace Bitrix\Tasks\Grid\Scrum\Row;

use \Bitrix\Main\Grid;
use Bitrix\Main\Web\Json;
use Bitrix\Tasks\Internals\Counter\Template\CounterStyle;
use Bitrix\Tasks\Internals\Counter\Template\ScrumCounter;

/**
 * Class Counter
 *
 * @package Bitrix\Tasks\Grid\Scrum\Row
 */
class Counter
{
	protected $rowData = [];
	protected $parameters = [];

	/**
	 * Action constructor.
	 *
	 * @param array $rowData
	 * @param array $parameters
	 */
	public function __construct(array $rowData = [], array $parameters = [])
	{
		$this->rowData = $rowData;
		$this->parameters = $parameters;
	}

	public function prepare(): array
	{
		$userId = (int)$this->parameters['USER_ID'];
		$groupId = (int)$this->rowData['ID'];
		$groupUrl = $this->rowData['PATH'];

		$counter = [
			'COLOR' => CounterStyle::STYLE_GRAY,
			'VALUE' => 0,
		];

		if (
			array_key_exists($userId, $this->rowData['MEMBERS']['HEADS'])
			|| array_key_exists($userId, $this->rowData['MEMBERS']['MEMBERS'])
		)
		{
			$counter = (new ScrumCounter($userId))->getRowCounter($groupId);
		}

		$colorMap = [
			CounterStyle::STYLE_GRAY => Grid\Counter\Color::GRAY,
			CounterStyle::STYLE_GREEN => Grid\Counter\Color::SUCCESS,
		];

		$sliderOptions = Json::encode([
			'contentClassName' => 'bitrix24-group-slider-content',
			'loader' => 'intranet:tasklist',
			'cacheable' => false,
			'customLeftBoundary' => 0,
			'newWindowLabel' => true,
			'copyLinkLabel' => true,
		]);

		return [
			'ACTIVITY_DATE' => [
				'type' => Grid\Counter\Type::LEFT_ALIGNED,
				'color' => $colorMap[$counter['COLOR']],
				'value' => $counter['VALUE'],
				'events' => [
					'click' => "BX.SidePanel.Instance.open.bind(BX.SidePanel.Instance, '{$groupUrl}', {$sliderOptions})",
				],
				'class' => 'tasks-projects-counter',
			],
		];
	}
}