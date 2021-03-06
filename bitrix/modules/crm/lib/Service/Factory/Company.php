<?php

namespace Bitrix\Crm\Service\Factory;

use Bitrix\Crm\Category\Entity\Category;
use Bitrix\Crm\Category\Entity\ClientDefaultCategory;
use Bitrix\Crm\Category\Entity\ItemCategory;
use Bitrix\Crm\CompanyTable;
use Bitrix\Crm\Conversion\EntityConversionConfig;
use Bitrix\Crm\Field;
use Bitrix\Crm\Item;
use Bitrix\Crm\Model\ItemCategoryTable;
use Bitrix\Crm\Service;
use Bitrix\Crm\Service\Context;
use Bitrix\Crm\Service\EventHistory\TrackedObject;
use Bitrix\Crm\Service\Operation;
use Bitrix\Crm\Settings\CompanySettings;
use Bitrix\Crm\StatusTable;
use Bitrix\Main\InvalidOperationException;
use Bitrix\Main\IO\Path;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\NotSupportedException;

final class Company extends Service\Factory
{
	protected $itemClassName = Item\Company::class;

	public function __construct()
	{
		Loc::loadMessages(Path::combine(__DIR__, '..', '..', 'classes', 'general', 'crm_company.php'));
	}

	public function isNewRoutingForDetailEnabled(): bool
	{
		return false;
	}

	public function isRecyclebinEnabled(): bool
	{
		return CompanySettings::getCurrent()->isRecycleBinEnabled();
	}

	public function isDeferredCleaningEnabled(): bool
	{
		return CompanySettings::getCurrent()->isDeferredCleaningEnabled();
	}

	public function isNewRoutingForAutomationEnabled(): bool
	{
		return false;
	}

	public function isUseInUserfieldEnabled(): bool
	{
		return true;
	}

	public function isCrmTrackingEnabled(): bool
	{
		return true;
	}

	public function isStagesSupported(): bool
	{
		return false;
	}

	public function isStagesEnabled(): bool
	{
		return false;
	}

	public function getStagesEntityId(?int $categoryId = null): ?string
	{
		throw new NotSupportedException('Company doesn\'t support stages');
	}

	public function isNewRoutingForListEnabled(): bool
	{
		return false;
	}

	public function isBizProcEnabled(): bool
	{
		return true;
	}

	public function isMultiFieldsEnabled(): bool
	{
		return true;
	}

	public function getDataClass(): string
	{
		return CompanyTable::class;
	}

	/**
	 * @inheritDoc
	 */
	public function getFieldsMap(): array
	{
		return [
			Item::FIELD_NAME_CREATED_TIME => 'DATE_CREATE',
			Item::FIELD_NAME_UPDATED_TIME => 'DATE_MODIFY',
			Item::FIELD_NAME_CREATED_BY => 'CREATED_BY_ID',
			Item::FIELD_NAME_UPDATED_BY => 'MODIFY_BY_ID',
			Item::FIELD_NAME_TYPE_ID => 'COMPANY_TYPE',
//			Item::FIELD_NAME_CONTACTS => Item::FIELD_NAME_CONTACT_ID,
		];
	}

	public function getEntityTypeId(): int
	{
		return \CCrmOwnerType::Company;
	}

	protected function getFieldsSettings(): array
	{
		return [
			Item::FIELD_NAME_ID => [
				'TYPE' => Field::TYPE_INTEGER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly, \CCrmFieldInfoAttr::AutoGenerated],
			],
			Item::FIELD_NAME_TITLE => [
				'TYPE' => Field::TYPE_STRING,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::Required],
			],
			Item::FIELD_NAME_TYPE_ID => [
				'TYPE' => Field::TYPE_CRM_STATUS,
				'CRM_STATUS_TYPE' => StatusTable::ENTITY_ID_COMPANY_TYPE,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::HasDefaultValue],
			],
			Item\Company::FIELD_NAME_LOGO => [
				'TYPE' => Field::TYPE_FILE,
				'VALUE_TYPE' => Field::VALUE_TYPE_IMAGE,
			],
			Item\Company::FIELD_NAME_INDUSTRY => [
				'TYPE' => Field::TYPE_CRM_STATUS,
				'CRM_STATUS_TYPE' => StatusTable::ENTITY_ID_INDUSTRY,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::HasDefaultValue],
			],
			Item\Company::FIELD_NAME_EMPLOYEES => [
				'TYPE' => Field::TYPE_CRM_STATUS,
				'CRM_STATUS_TYPE' => StatusTable::ENTITY_ID_EMPLOYEES,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::HasDefaultValue],
			],
			Item::FIELD_NAME_CURRENCY_ID => [
				'TYPE' => Field::TYPE_CRM_CURRENCY,
			],
			Item\Company::FIELD_NAME_REVENUE => [
				'TYPE' => Field::TYPE_DOUBLE,
			],
			Item::FIELD_NAME_OPENED => [
				'TYPE' => Field::TYPE_BOOLEAN,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::Required],
				'CLASS' => Field\Opened::class,
			],
			Item::FIELD_NAME_COMMENTS => [
				'TYPE' => Field::TYPE_TEXT,
				'ATTRIBUTES' => [],
				'VALUE_TYPE' => Field::VALUE_TYPE_HTML,
			],
			Item\Company::FIELD_NAME_IS_MY_COMPANY => [
				'TYPE' => Field::TYPE_BOOLEAN,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly],
			],
			Item::FIELD_NAME_ASSIGNED => [
				'TYPE' => Field::TYPE_USER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::Required],
				'CLASS' => Field\Assigned::class,
			],
			Item::FIELD_NAME_CREATED_BY => [
				'TYPE' => Field::TYPE_USER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly],
				'CLASS' => Field\CreatedBy::class,
			],
			Item::FIELD_NAME_UPDATED_BY => [
				'TYPE' => Field::TYPE_USER,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly],
				'CLASS' => Field\UpdatedBy::class,
			],
			Item::FIELD_NAME_CREATED_TIME => [
				'TYPE' => Field::TYPE_DATETIME,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly],
				'CLASS' => Field\CreatedTime::class,
			],
			Item::FIELD_NAME_UPDATED_TIME => [
				'TYPE' => Field::TYPE_DATETIME,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::ReadOnly],
				'CLASS' => Field\UpdatedTime::class,
			],
//			Item::FIELD_NAME_CONTACT_ID => [
//				'TYPE' => Field::TYPE_CRM_CONTACT,
//				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed, \CCrmFieldInfoAttr::Multiple],
//			],
			Item::FIELD_NAME_LEAD_ID => [
				'TYPE' => Field::TYPE_CRM_LEAD,
				'SETTINGS' => [
					'parentEntityTypeId' => \CCrmOwnerType::Lead,
				],
			],
			Item::FIELD_NAME_ORIGINATOR_ID => [
				'TYPE' => Field::TYPE_STRING,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed],
			],
			Item::FIELD_NAME_ORIGIN_ID => [
				'TYPE' => Field::TYPE_STRING,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed],
			],
			Item::FIELD_NAME_ORIGIN_VERSION => [
				'TYPE' => Field::TYPE_STRING,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed],
			],
			Item::FIELD_NAME_CATEGORY_ID => [
				'TYPE' => Field::TYPE_CRM_CATEGORY,
				'ATTRIBUTES' => [\CCrmFieldInfoAttr::NotDisplayed, \CCrmFieldInfoAttr::HasDefaultValue],
				'CLASS' => Field\Category::class,
			],
		];
	}

	/**
	 * Returns true if this entity supports categories.
	 *
	 * @return bool
	 */
	public function isCategoriesSupported(): bool
	{
		return true;
	}

	public function createCategory(array $data = []): Category
	{
		$object = ItemCategoryTable::createObject($data);
		$object->setEntityTypeId($this->getEntityTypeId());

		return new ItemCategory($object);
	}

	protected function loadCategories(): array
	{
		$categories = ItemCategoryTable::getItemCategoriesByEntityTypeId($this->getEntityTypeId());

		Service\Container::getInstance()->getLocalization()->loadMessages();
		$defaultCategory = new ClientDefaultCategory(
			$this->getEntityTypeId(),
			Loc::getMessage("CRM_TYPE_CATEGORY_DEFAULT_NAME"),
			0
		);

		array_unshift($categories, $defaultCategory);

		return $categories;
	}

	protected function getTrackedFieldNames(): array
	{
		return [
			Item::FIELD_NAME_TITLE,
			Item::FIELD_NAME_ASSIGNED,
		];
	}

	protected function getDependantTrackedObjects(): array
	{
		$objects = [];

		$contactTrackedObject = new TrackedObject\Contact();
		$contactTrackedObject->makeThisObjectDependant(Item::FIELD_NAME_CONTACTS);
		$objects[] = $contactTrackedObject;

		return $objects;
	}

	public function getAddOperation(Item $item, Context $context = null): Operation\Add
	{
		// duplication and statistic procession is not ready yet
		throw new InvalidOperationException('Company factory is not ready to work with operations yet');
	}

	public function getUpdateOperation(Item $item, Context $context = null): Operation\Update
	{
		throw new InvalidOperationException('Company factory is not ready to work with operations yet');
	}

	public function getDeleteOperation(Item $item, Context $context = null): Operation\Delete
	{
		throw new InvalidOperationException('Company factory is not ready to work with operations yet');
	}

	public function getConversionOperation(
		Item $item,
		EntityConversionConfig $configs,
		Context $context = null
	): Service\Operation\Conversion
	{
		throw new InvalidOperationException('Company factory is not ready to work with operations yet');
	}

	public function getCopyOperation(Item $item, Context $context = null): Operation\Copy
	{
		throw new InvalidOperationException('Company factory is not ready to work with operations yet');
	}

	public function getRestoreOperation(Item $item, Context $context = null): Operation\Restore
	{
		throw new InvalidOperationException('Company factory is not ready to work with operations yet');
	}

	public function getImportOperation(Item $item, Context $context = null): Operation\Import
	{
		throw new InvalidOperationException('Company factory is not ready to work with operations yet');
	}

	public function isCountersEnabled(): bool
	{
		return true;
	}
}
