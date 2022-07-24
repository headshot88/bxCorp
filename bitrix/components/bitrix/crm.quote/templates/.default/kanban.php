<?php if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true)die();

// js/css
$APPLICATION->SetAdditionalCSS('/bitrix/themes/.default/bitrix24/crm-entity-show.css');
$bodyClass = $APPLICATION->GetPageProperty('BodyClass');
$APPLICATION->SetPageProperty('BodyClass', ($bodyClass ? $bodyClass.' ' : '').'no-paddings grid-mode pagetitle-toolbar-field-view crm-toolbar');
$asset = Bitrix\Main\Page\Asset::getInstance();
$asset->addJs('/bitrix/js/crm/common.js');

// some common langs
use Bitrix\Main\Localization\Loc;
Loc::loadMessages($_SERVER['DOCUMENT_ROOT'].'/bitrix/components/bitrix/crm.quote.menu/component.php');
Loc::loadMessages($_SERVER['DOCUMENT_ROOT'].'/bitrix/components/bitrix/crm.quote.list/templates/.default/template.php');

// if not isset
$arResult['PATH_TO_QUOTE_EDIT'] = isset($arResult['PATH_TO_QUOTE_EDIT']) ? $arResult['PATH_TO_QUOTE_EDIT'] : '';
$arResult['PATH_TO_QUOTE_LIST'] = isset($arResult['PATH_TO_QUOTE_LIST']) ? $arResult['PATH_TO_QUOTE_LIST'] : '';
$arResult['PATH_TO_QUOTE_KANBAN'] = isset($arResult['PATH_TO_QUOTE_KANBAN']) ? $arResult['PATH_TO_QUOTE_KANBAN'] : '';
$arResult['PATH_TO_QUOTE_DETAILS'] = $arResult['PATH_TO_QUOTE_DETAILS'] ?? '';

// csv and excel delegate to list
$context = \Bitrix\Main\Application::getInstance()->getContext();
$request = $context->getRequest();
if (in_array($request->get('type'), array('csv', 'excel')))
{
	LocalRedirect(str_replace(
				$arResult['PATH_TO_QUOTE_KANBAN'],
				$arResult['PATH_TO_QUOTE_LIST'],
				$APPLICATION->getCurPageParam()
			), true);
}

// main menu
$APPLICATION->IncludeComponent(
	'bitrix:crm.control_panel',
	'',
	[
		'ID' => 'QUOTE_LIST',
		'ACTIVE_ITEM_ID' => 'QUOTE',
		'PATH_TO_COMPANY_LIST' => isset($arResult['PATH_TO_COMPANY_LIST']) ? $arResult['PATH_TO_COMPANY_LIST'] : '',
		'PATH_TO_COMPANY_EDIT' => isset($arResult['PATH_TO_COMPANY_EDIT']) ? $arResult['PATH_TO_COMPANY_EDIT'] : '',
		'PATH_TO_CONTACT_LIST' => isset($arResult['PATH_TO_CONTACT_LIST']) ? $arResult['PATH_TO_CONTACT_LIST'] : '',
		'PATH_TO_CONTACT_EDIT' => isset($arResult['PATH_TO_CONTACT_EDIT']) ? $arResult['PATH_TO_CONTACT_EDIT'] : '',
		'PATH_TO_LEAD_LIST' => isset($arResult['PATH_TO_LEAD_LIST']) ? $arResult['PATH_TO_LEAD_LIST'] : '',
		'PATH_TO_LEAD_EDIT' => isset($arResult['PATH_TO_LEAD_EDIT']) ? $arResult['PATH_TO_LEAD_EDIT'] : '',
		'PATH_TO_DEAL_LIST' => isset($arResult['PATH_TO_DEAL_LIST']) ? $arResult['PATH_TO_DEAL_LIST'] : '',
		'PATH_TO_DEAL_EDIT' => isset($arResult['PATH_TO_DEAL_EDIT']) ? $arResult['PATH_TO_DEAL_EDIT'] : '',
		'PATH_TO_QUOTE_LIST' => isset($arResult['PATH_TO_QUOTE_LIST']) ? $arResult['PATH_TO_QUOTE_LIST'] : '',
		'PATH_TO_QUOTE_DETAILS' => $arResult['PATH_TO_QUOTE_DETAILS'] ?? '',
		'PATH_TO_QUOTE_EDIT' => isset($arResult['PATH_TO_QUOTE_EDIT']) ? $arResult['PATH_TO_QUOTE_EDIT'] : '',
		'PATH_TO_INVOICE_LIST' => isset($arResult['PATH_TO_INVOICE_LIST']) ? $arResult['PATH_TO_INVOICE_LIST'] : '',
		'PATH_TO_INVOICE_EDIT' => isset($arResult['PATH_TO_INVOICE_EDIT']) ? $arResult['PATH_TO_INVOICE_EDIT'] : '',
		'PATH_TO_REPORT_LIST' => isset($arResult['PATH_TO_REPORT_LIST']) ? $arResult['PATH_TO_REPORT_LIST'] : '',
		'PATH_TO_DEAL_FUNNEL' => isset($arResult['PATH_TO_DEAL_FUNNEL']) ? $arResult['PATH_TO_DEAL_FUNNEL'] : '',
		'PATH_TO_EVENT_LIST' => isset($arResult['PATH_TO_EVENT_LIST']) ? $arResult['PATH_TO_EVENT_LIST'] : '',
		'PATH_TO_PRODUCT_LIST' => isset($arResult['PATH_TO_PRODUCT_LIST']) ? $arResult['PATH_TO_PRODUCT_LIST'] : ''
	],
	$component
);

// check rights
if (!\CCrmPerms::IsAccessEnabled())
{
	return false;
}

// check accessable
if (!Bitrix\Crm\Integration\Bitrix24Manager::isAccessEnabled(CCrmOwnerType::Quote))
{
	$APPLICATION->IncludeComponent('bitrix:bitrix24.business.tools.info', '', []);
}
else
{
	$entityType = \CCrmOwnerType::QuoteName;

	// counters stub
	$isBitrix24Template = SITE_TEMPLATE_ID === 'bitrix24';
	if($isBitrix24Template)
	{
		$this->SetViewTarget('below_pagetitle', 1000);
	}

	$APPLICATION->IncludeComponent(
		'bitrix:crm.entity.counter.panel',
		'',
		['ENTITY_TYPE_NAME' => $entityType]
	);

	if($isBitrix24Template)
	{
		$this->EndViewTarget();
	}

	// menu
	$APPLICATION->IncludeComponent(
		'bitrix:crm.quote.menu',
		'',
		[
			'PATH_TO_QUOTE_LIST' => $arResult['PATH_TO_QUOTE_LIST'],
			'PATH_TO_QUOTE_EDIT' => $arResult['PATH_TO_QUOTE_EDIT'],
			'PATH_TO_QUOTE_DETAILS' => $arResult['PATH_TO_QUOTE_DETAILS'],
			'ELEMENT_ID' => 0,
			'TYPE' => 'list',
			'DISABLE_EXPORT' => 'Y'
		],
		$component
	);

	// filter
	$APPLICATION->IncludeComponent(
		'bitrix:crm.kanban.filter',
		'',
		[
			'ENTITY_TYPE' => $entityType,
			'NAVIGATION_BAR' => [
				'ITEMS' => array_merge(
					\Bitrix\Crm\Automation\Helper::getNavigationBarItems(\CCrmOwnerType::Quote),
					[
						[
							//'icon' => 'kanban',
							'id' => 'kanban',
							'name' => Loc::getMessage('CRM_QUOTE_LIST_FILTER_NAV_BUTTON_KANBAN'),
							'active' => 1,
							'url' => $arResult['PATH_TO_QUOTE_KANBAN']
						],
						[
							//'icon' => 'table',
							'id' => 'list',
							'name' => Loc::getMessage('CRM_QUOTE_LIST_FILTER_NAV_BUTTON_LIST'),
							'active' => 0,
							'url' => $arResult['PATH_TO_QUOTE_LIST']
						]
					]
				),
				'BINDING' => [
					'category' => 'crm.navigation',
					'name' => 'index',
					'key' => mb_strtolower($arResult['NAVIGATION_CONTEXT_ID'])
				]
			]
		],
		$component,
		['HIDE_ICONS' => true]
	);

	/*
	$supervisorInv = \Bitrix\Crm\Kanban\SupervisorTable::isSupervisor($entityType) ? 'N' : 'Y';
	CCrmUrlUtil::AddUrlParams(
				CComponentEngine::MakePathFromTemplate(
					$arResult['PATH_TO_QUOTE_KANBAN']
				),
				array('supervisor' => $supervisorInv, 'clear_filter' => 'Y')
			)*/

	\Bitrix\Crm\Service\Container::getInstance()->getLocalization()->loadMessages();

	$APPLICATION->IncludeComponent(
		'bitrix:crm.kanban',
		'',
		[
			'ENTITY_TYPE' => $entityType,
			'PATH_TO_QUOTE_DETAILS' => $arResult['PATH_TO_QUOTE_DETAILS'],
			'HEADERS_SECTIONS' => [
				[
					'id'=> CCrmOwnerType::QuoteName,
					'name' => Loc::getMessage('CRM_COMMON_QUOTE'),
					'default' => true,
					'selected' => true,
				],
			],
		],
		$component
	);
}
