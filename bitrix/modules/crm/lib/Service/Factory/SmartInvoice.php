<?php

namespace Bitrix\Crm\Service\Factory;

use Bitrix\Crm\Automation\Trigger\InvoiceTrigger;
use Bitrix\Crm\Field;
use Bitrix\Crm\Integration\DocumentGeneratorManager;
use Bitrix\Crm\Integration\DocumentGenerator\DataProvider;
use Bitrix\Crm\InvoiceTable;
use Bitrix\Crm\Item;
use Bitrix\Crm\Model\Dynamic\TypeTable;
use Bitrix\Crm\Relation;
use Bitrix\Crm\RelationIdentifier;
use Bitrix\Crm\Security\Role\RolePermission;
use Bitrix\Crm\Service\Container;
use Bitrix\Crm\Service\Context;
use Bitrix\Crm\Service\EditorAdapter;
use Bitrix\Crm\Service\Operation;
use Bitrix\Crm\Settings\InvoiceSettings;
use Bitrix\Crm\UserField\UserFieldManager;
use Bitrix\Main\Error;
use Bitrix\Main\Localization\Loc;
use Bitrix\Main\ORM\Data\AddResult;
use Bitrix\Main\Result;
use Bitrix\Main\Type\DateTime;

class SmartInvoice extends Dynamic
{
	protected $itemClassName = Item\SmartInvoice::class;

	public const USER_FIELD_ENTITY_ID = 'CRM_SMART_INVOICE';
	public const SUSPENDED_USER_FIELD_ENTITY_ID = 'CRM_SMART_INVOICE_SPD';

	public const NUMERATOR_TYPE = 'CRM_SMART_INVOICE';

	public function getEntityDescription(): string
	{
		return \CCrmOwnerType::GetDescription(\CCrmOwnerType::SmartInvoice);
	}

	public function getUserFieldEntityId(): string
	{
		return static::USER_FIELD_ENTITY_ID;
	}

	public function isPaymentsEnabled(): bool
	{
		return true;
	}

	protected function getFieldTitlesMap(): array
	{
		$map = parent::getFieldTitlesMap();

		$map[Item::FIELD_NAME_BEGIN_DATE] = Loc::getMessage('CRM_TYPE_SMART_INVOICE_FIELD_BEGIN_DATE');
		$map[Item::FIELD_NAME_CLOSE_DATE] = Loc::getMessage('CRM_TYPE_SMART_INVOICE_FIELD_CLOSE_DATE');

		return $map;
	}

	public function getFieldsSettings(): array
	{
		$settings = parent::getFieldsSettings();

		//do not use Field\Title here. Empty title for invoice is a desirable behaviour
		unset($settings[Item::FIELD_NAME_TITLE]['CLASS']);

		$settings[Item::FIELD_NAME_MYCOMPANY_ID]['SETTINGS']['isEmbeddedEditorEnabled'] = true;

		$settings[Item\SmartInvoice::FIELD_NAME_COMMENTS] = [
			'TYPE' => Field::TYPE_TEXT,
			'VALUE_TYPE' => Field::VALUE_TYPE_HTML,
		];
		$settings[Item\SmartInvoice::FIELD_NAME_ACCOUNT_NUMBER] = [
			'TYPE' => Field::TYPE_STRING,
			'CLASS' => Field\Number::class,
			'ATTRIBUTES' => [\CCrmFieldInfoAttr::AutoGenerated, \CCrmFieldInfoAttr::Unique],
			'SETTINGS' => [
				'numeratorType' => static::NUMERATOR_TYPE,
				'numeratorIdSettings' => Item::FIELD_NAME_ID,
				'tableClassName' => $this->getDataClass(),
				// 'fieldValueNotUniqueErrorMessage' =>
				// 	Loc::getMessage('CRM_SERVICE_FACTORY_SMART_INVOICE_NUMBER_NOT_UNIQUE_ERROR'),
			],
		];

		$locationAttributes = [];
		if (!Container::getInstance()->getAccounting()->isTaxMode())
		{
			$locationAttributes = [\CCrmFieldInfoAttr::NotDisplayed];
		}
		$settings[Item::FIELD_NAME_LOCATION_ID] = [
			'TYPE' => Field::TYPE_LOCATION,
			'ATTRIBUTES' => $locationAttributes,
		];

		return $settings;
	}

	protected function prepareGetListParameters(array $parameters): array
	{
		$parameters = parent::prepareGetListParameters($parameters);
		if (
			isset($parameters['select'])
			&& !in_array('*', $parameters['select'], true)
			&& in_array(Item::FIELD_NAME_TITLE, $parameters['select'], true)
		)
		{
			$parameters['select'][] = Item\SmartInvoice::FIELD_NAME_ACCOUNT_NUMBER;
			$parameters['select'][] = Item\SmartInvoice::FIELD_NAME_BEGIN_DATE;
		}

		return $parameters;
	}

	public static function createTypeIfNotExists(): void
	{
		$type = TypeTable::getByEntityTypeId(\CCrmOwnerType::SmartInvoice)->fetchObject();
		if ($type)
		{
			return;
		}

		Container::getInstance()->getLocalization()->loadMessages();

		$type =
			TypeTable::createObject()
			->setName('SmartInvoice')
			->setEntityTypeId(\CCrmOwnerType::SmartInvoice)
			->setTitle('Smart Invoice')
			->setCode('BX_SMART_INVOICE')
			->setCreatedBy(0)
			->setIsCategoriesEnabled(false)
			->setIsStagesEnabled(true)
			->setIsBeginCloseDatesEnabled(true)
			->setIsClientEnabled(true)
			->setIsUseInUserfieldEnabled(true)
			->setIsLinkWithProductsEnabled(true)
			->setIsCrmTrackingEnabled(true)
			->setIsMycompanyEnabled(true)
			->setIsDocumentsEnabled(true)
			->setIsSourceEnabled(true)
			->setIsObserversEnabled(true)
			->setIsRecyclebinEnabled(true)
			->setIsAutomationEnabled(true)
			->setIsBizProcEnabled(true)
			->setIsPaymentsEnabled(true)
		;

		/** @var AddResult $result */
		$result = $type->save();
		if ($result->isSuccess())
		{
			$userFieldsMap = UserFieldManager::getLinkedUserFieldsMap();
			foreach ($userFieldsMap as $ufName => $description)
			{
				$isSuccess = UserFieldManager::enableEntityInUserField($description, \CCrmOwnerType::SmartInvoiceName, true);
				if (!$isSuccess)
				{
					$result->addError(new Error("Attempt to enable SmartInvoice in user field {$ufName} was unsuccessful"));
				}
			}

			// add parent fields
			$conversionSettings =
				(new Relation\Settings())
					->setRelationType(Relation\RelationType::CONVERSION)
					->setIsChildrenListEnabled(true)
			;

			$relationManager = Container::getInstance()->getRelationManager();

			$bindResult = $relationManager->bindTypes(
				new Relation(
					new RelationIdentifier(\CCrmOwnerType::Deal, \CCrmOwnerType::SmartInvoice),
					clone $conversionSettings,
				)
			);
			if (!$bindResult->isSuccess())
			{
				$result->addErrors($bindResult->getErrors());
			}

			$bindResult = $relationManager->bindTypes(
				new Relation(
					new RelationIdentifier(\CCrmOwnerType::Quote, \CCrmOwnerType::SmartInvoice),
					clone $conversionSettings,
				)
			);
			if (!$bindResult->isSuccess())
			{
				$result->addErrors($bindResult->getErrors());
			}

			$factory = Container::getInstance()->getFactory(\CCrmOwnerType::SmartInvoice);
			if ($factory)
			{
				// copy permissions
				$defaultCategoryId = $factory->createDefaultCategoryIfNotExist()->getId();
				$userPermissions = Container::getInstance()->getUserPermissions();
				$smartInvoicePermissionEntity = $userPermissions::getPermissionEntityType(
					\CCrmOwnerType::SmartInvoice,
					$defaultCategoryId
				);
				$oldInvoicePermissionEntity = $userPermissions::getPermissionEntityType(\CCrmOwnerType::Invoice);
				$permissions = RolePermission::getByEntityId($oldInvoicePermissionEntity);
				$permissionsCopingResult = RolePermission::setByEntityId($smartInvoicePermissionEntity, $permissions);
				if (!$permissionsCopingResult->isSuccess())
				{
					$result->addErrors($permissionsCopingResult->getErrors());
				}

				// bind templates
				$documentGeneratorManager = DocumentGeneratorManager::getInstance();
				if ($documentGeneratorManager->isEnabled())
				{
					$invoicesProvider = DataProvider\Invoice::class;

					$smartInvoiceProviderCode = DataProvider\SmartInvoice::getProviderCode(
						\CCrmOwnerType::SmartInvoice,
						$factory->getDefaultCategory()->getId()
					);
					$copyTemplatesResult = $documentGeneratorManager->copyTemplatesProviders($invoicesProvider, $smartInvoiceProviderCode);
					if (!$copyTemplatesResult->isSuccess())
					{
						$result->addErrors($copyTemplatesResult->getErrors());
					}
				}

				// hide old invoices if there are no invoices created during last month
				$lastMonthCreatedInvoicesCount = InvoiceTable::getCount([
					'>DATE_INSERT' => DateTime::createFromTimestamp(time() - 30 * 24 * 3600),
				]);
				InvoiceSettings::getCurrent()->setOldInvoicesEnabled($lastMonthCreatedInvoicesCount > 0);

				// if there is at least one old invoice - show notification where to find them
				if ($lastMonthCreatedInvoicesCount <= 0)
				{
					$lastSixMonthgsCreatedInvoicesCount = InvoiceTable::getCount([
						'>DATE_INSERT' => DateTime::createFromTimestamp(time() - 183 * 24 * 3600),
					]);
					InvoiceSettings::getCurrent()->setShowInvoiceTransitionNotice($lastSixMonthgsCreatedInvoicesCount > 10);
				}
			}
			else
			{
				$result->addError(new Error('Factory for SmartInvoice was not found'));
			}
		}

		if (!$result->isSuccess())
		{
			AddMessage2Log(
				'Error while trying to create SmartInvoice type: ' . implode(', ', $result->getErrorMessages()),
				'crm',
			);
		}
	}

	public function getEditorAdapter(): EditorAdapter
	{
		$adapter = parent::getEditorAdapter();

		$locationField = $this->getFieldsCollection()->getField(Item::FIELD_NAME_LOCATION_ID);
		if ($locationField && $locationField->isDisplayed())
		{
			$adapter->addEntityField(EditorAdapter::getLocationFieldDescription($locationField));
		}

		$opportunityField = EditorAdapter::getOpportunityField(
			$this->getFieldCaption(EditorAdapter::FIELD_OPPORTUNITY),
			EditorAdapter::FIELD_OPPORTUNITY,
			$this->isPaymentsEnabled()
		);

		$opportunityField['data']['paymentDocumentsPhrases'] = [
			'CRM_ENTITY_ED_PAYMENT_DOCUMENTS_TITLE' => 'CRM_ENTITY_ED_PAYMENT_DOCUMENTS_INVOICE_TITLE',
			'CRM_ENTITY_ED_PAYMENT_DOCUMENTS_TOTAL_SUM' => 'CRM_ENTITY_ED_PAYMENT_DOCUMENTS_INVOICE_TOTAL_SUM',
			'CRM_ENTITY_ED_PAYMENT_DOCUMENTS_TOTAL_SUM_TOOLTIP' => 'CRM_ENTITY_ED_PAYMENT_DOCUMENTS_INVOICE_TOTAL_SUM_TOOLTIP',
		];

		$adapter->addEntityField($opportunityField);

		return $adapter;
	}

	public function getUpdateOperation(Item $item, Context $context = null): Operation\Update
	{
		$operation = parent::getUpdateOperation($item, $context);

		$operation->addAction(
			Operation::ACTION_AFTER_SAVE,
			new class extends Operation\Action {
				public function process(Item $item): Result
				{
					$itemBeforeSave = $this->getItemBeforeSave();
					if (
						$itemBeforeSave
						&& $itemBeforeSave->isChangedStageId()
						&& $item instanceof Item\SmartInvoice
					)
					{
						InvoiceTrigger::onSmartInvoiceStatusChanged($item);
					}

					return new Result();
				}
			}
		);

		return $operation;
	}

	public static function updateConversionMaps(): void
	{
		$factory = Container::getInstance()->getFactory(\CCrmOwnerType::SmartInvoice);
		if (!$factory)
		{
			return;
		}
		$relationManager = Container::getInstance()->getRelationManager();
		$mapper = Container::getInstance()->getConversionMapper();
		foreach ($relationManager->getParentRelations(\CCrmOwnerType::SmartInvoice) as $relation)
		{
			if ($relation->getSettings()->isConversion())
			{
				$map = $mapper->createMap($relation->getIdentifier());
				if ($map)
				{
					$map->save();
				}
			}
		}
	}
}
