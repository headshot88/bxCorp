<?php

namespace Bitrix\Crm\Integration\UI\EntitySelector;

use Bitrix\Crm\CompanyTable;

class CompanyProvider extends EntityProvider
{
	/** @var CompanyTable */
	protected static $dataClass = CompanyTable::class;

	protected $enableMyCompanyOnly = false;
	protected $categoryId;

	public function __construct(array $options = [])
	{
		parent::__construct($options);

		$this->categoryId = (int)($options['categoryId'] ?? 0);
		$this->options['categoryId'] = $this->categoryId;

		$this->enableMyCompanyOnly = (bool)($options['enableMyCompanyOnly'] ?? $this->enableMyCompanyOnly);
		$this->options['enableMyCompanyOnly'] = $this->enableMyCompanyOnly;
	}

	public function getRecentItemIds(string $context): array
	{
		if($this->enableMyCompanyOnly)
		{
			$ids = CompanyTable::getList([
				'select' => ['ID'],
				'order' => [
					'ID' => 'ASC',
				],
				'filter' => [
					'=IS_MY_COMPANY' => 'Y',
				],
			])->fetchCollection()->getIdList();
		}
		else
		{
			$ids = parent::getRecentItemIds($context);
		}

		return $ids;
	}

	protected function getEntityTypeId(): int
	{
		return \CCrmOwnerType::Company;
	}

	protected function fetchEntryIds(array $filter): array
	{
		if ($this->enableMyCompanyOnly)
		{
			$filter['=IS_MY_COMPANY'] = 'Y';
		}
		$filter['=CATEGORY_ID'] = $this->categoryId;

		$collection = static::$dataClass::getList([
			'select' => ['ID'],
			'filter' => $filter,
		])->fetchCollection();

		return $collection->getIdList();
	}

	protected function getAdditionalFilter(): array
	{
		$filter = [
			'=CATEGORY_ID' =>  $this->categoryId,
		];
		if ($this->enableMyCompanyOnly)
		{
			$filter['=IS_MY_COMPANY'] = 'Y';
		}

		return $filter;
	}
}
