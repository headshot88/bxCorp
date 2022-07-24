<?php


namespace Bitrix\Crm\Service\Display\Field;


use Bitrix\Crm\Service\Display\Options;
use Bitrix\Main\Text\HtmlFilter;

class CrmStatusField extends BaseSimpleField
{
	protected const TYPE = 'crm_status';

	protected function getFormattedValueForKanban($fieldValue, int $itemId, Options $displayOptions)
	{
		$this->setWasRenderedAsHtml(true);
		$entityType = $this->getDisplayParam('ENTITY_TYPE');
		$statuses = ($entityType ? \CCrmStatus::GetStatusList($entityType) : []);

		$isMultiple = $this->isMultiple();
		$result = ($isMultiple ? [] : '');

		foreach ((array)$fieldValue as $value)
		{
			if (isset($statuses[$value]))
			{
				$encodedStatusValue = HtmlFilter::encode($statuses[$value]);
				if (!$isMultiple)
				{
					return $encodedStatusValue;
				}

				$result[] = $encodedStatusValue;
			}
		}

		return $result;
	}

	protected function getFormattedValueForGrid($fieldValue, int $itemId, Options $displayOptions)
	{
		$results = $this->getFormattedValueForKanban($fieldValue, $itemId, $displayOptions);
		return (
		is_array($results)
			? implode($displayOptions->getMultipleFieldsDelimiter(), $results)
			: $results
		);
	}
}
