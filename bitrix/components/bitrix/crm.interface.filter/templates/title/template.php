<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
/**
 * Bitrix vars
 * @global CUser $USER
 * @global CMain $APPLICATION
 * @global CDatabase $DB
 * @var array $arParams
 * @var array $arResult
 * @var CBitrixComponent $component
 */

$gridID = $arParams['~GRID_ID'];
$gridIDLc = mb_strtolower($gridID);
$filterID = isset($arParams['~FILTER_ID']) ? $arParams['~FILTER_ID'] : $gridID;
$filterIDLc = mb_strtolower($filterID);

//region Prepare custom fields
if(isset($arParams['~FILTER']) && is_array($arParams['~FILTER']))
{
	$entitySelectors = array();
	foreach($arParams['~FILTER'] as $filterItem)
	{
		if(!(isset($filterItem['type'])
			&& $filterItem['type'] === 'custom_entity'
			&& isset($filterItem['selector'])
			&& is_array($filterItem['selector']))
		)
		{
			continue;
		}

		$selector = $filterItem['selector'];

		$selectorType = isset($selector['TYPE']) ? $selector['TYPE'] : '';
		$selectorData = isset($selector['DATA']) && is_array($selector['DATA']) ? $selector['DATA'] : null;
		if(!isset($selectorData['IS_MULTIPLE']))
		{
			$selectorData['IS_MULTIPLE'] = isset($filterItem['params']['multiple']) && $filterItem['params']['multiple'] == 'Y';
		}

		if(empty($selectorData))
		{
			continue;
		}

		if($selectorType === 'crm_entity')
		{
			$entitySelectors[] = $selectorData;
		}
	}

	//region CRM Entity Selectors
	//It is always required for dymanic filter fields
	Bitrix\Main\Page\Asset::getInstance()->addJs('/bitrix/js/crm/crm.js');
	?><script type="text/javascript">
	BX.ready(
		function()
		{
			BX.CrmEntityType.setCaptions(<?=CUtil::PhpToJSObject(CCrmOwnerType::GetJavascriptDescriptions())?>);
			if(typeof(BX.CrmEntitySelector) !== "undefined")
			{
				BX.CrmEntitySelector.messages =
				{
					"selectButton": "<?=GetMessageJS('CRM_GRID_ENTITY_SEL_BTN')?>",
					"noresult": "<?=GetMessageJS('CRM_GRID_SEL_SEARCH_NO_RESULT')?>",
					"search": "<?=GetMessageJS('CRM_GRID_ENTITY_SEL_SEARCH')?>",
					"last": "<?=GetMessageJS('CRM_GRID_ENTITY_SEL_LAST')?>"
				};
			}
		}
	);
	</script><?
	if(!empty($entitySelectors))
	{
		?><script type="text/javascript"><?
			foreach($entitySelectors as $entitySelector)
			{
				$selectorID = $entitySelector['ID'];
				$fieldID = $entitySelector['FIELD_ID'];
				$entityTypeNames = $entitySelector['ENTITY_TYPE_NAMES'];
				$isMultiple = $entitySelector['IS_MULTIPLE'];
				$title = isset($entitySelector['TITLE']) ? $entitySelector['TITLE'] : '';
				?>BX.ready(
			function()
			{
				BX.CrmUIFilterEntitySelector.create(
					"<?=CUtil::JSEscape($selectorID)?>",
					{
						fieldId: "<?=CUtil::JSEscape($fieldID)?>",
						entityTypeNames: <?=CUtil::PhpToJSObject($entityTypeNames)?>,
						isMultiple: <?=$isMultiple ? 'true' : 'false'?>,
						title: "<?=CUtil::JSEscape($title)?>"
					}
				);
			}
		);<?
		}
		?></script><?
	}
	//endregion
}
//endregion

$isBitrix24Template = SITE_TEMPLATE_ID === 'bitrix24';

//region Filter Navgation Bar
$navigationBarConfig = null;
$navigationBarID = "{$filterIDLc}_nav_bar";
if(isset($arParams['~DISABLE_NAVIGATION_BAR']) &&  $arParams['~DISABLE_NAVIGATION_BAR'] === 'Y')
{
	$navigationBar = [];
}
else
{
	$navigationBar = isset($arParams['~NAVIGATION_BAR']) && is_array($arParams['~NAVIGATION_BAR'])
		? $arParams['~NAVIGATION_BAR']
		: [];
}

$automationButton = [];
$navigationBarItems = $navigationBar['ITEMS'] ?? null;
if(isset($navigationBarItems))
{
	$navigationBarConfig = ['items' => []];
	if(isset($navigationBar['BINDING']))
	{
		$navigationBarConfig['binding'] = $navigationBar['BINDING'];
	}

	if($isBitrix24Template)
	{
		$this->SetViewTarget('below_pagetitle', 100);
	}
	?><div class="crm-view-switcher"><div class="crm-view-switcher-list"><?

		$itemQty = 0;
		foreach($navigationBarItems as $barItem)
		{
			$itemQty++;
			$itemID = isset($barItem['id']) ? $barItem['id'] : $itemQty;
			$itemName = isset($barItem['name']) ? $barItem['name'] : $itemID;
			$itemUrl = isset($barItem['url']) ? $barItem['url'] : '';
			if($itemID === 'automation')
			{
				$automationButton['url'] = $itemUrl;
				$automationButton['name'] = $itemName;

				continue;
			}

			$itemElementID = mb_strtolower("{$gridID}_{$itemID}");
			$itemConfig = array('id' => $itemID, 'name' => $itemName, 'elementId' => $itemElementID, 'url' => $itemUrl);
			$className = 'crm-view-switcher-list-item';
			if(isset($barItem['active']) && $barItem['active'])
			{
				$itemConfig['active'] = true;
				$className = "{$className} crm-view-switcher-list-item-active";
			}
			$navigationBarConfig['items'][] = $itemConfig;
			?><div id="<?=htmlspecialcharsbx($itemElementID)?>" class="<?=$className?>">
				<?=htmlspecialcharsbx($itemName)?>
			</div><?
		}
		?></div>
	</div><?

	if($isBitrix24Template)
	{
		$this->EndViewTarget();
		$this->SetViewTarget('below_pagetitle', 10000);
	}

	?><div class="crm-view-switcher-buttons pagetitle-align-right-container"><?

		$bindingMenuMask = '/(lead|deal|invoice|quote|company|contact|order)/i';
		if (
			preg_match($bindingMenuMask, $arParams['GRID_ID'], $bindingMenuMatches) &&
			\Bitrix\Main\Loader::includeModule('intranet')
		)
		{
			\Bitrix\Main\UI\Extension::load('bizproc.script');
			$APPLICATION->includeComponent(
				'bitrix:intranet.binding.menu',
				'',
				[
					'SECTION_CODE' => \Bitrix\Crm\Integration\Intranet\BindingMenu\SectionCode::SWITCHER,
					'MENU_CODE' => $bindingMenuMatches[0],
				]
			);
		}

		if(!empty($automationButton))
		{
			?><a class="ui-btn ui-btn-light-border ui-btn-no-caps ui-btn-themes ui-btn-round crm-robot-btn" href="<?=htmlspecialcharsbx($automationButton['url'] )?>">
				<?=htmlspecialcharsbx($automationButton['name'] )?>
			</a><?
		}
	?></div>
	<script type="text/javascript">
		BX.ready(
			function()
			{
				BX.InterfaceGridFilterNavigationBar.create(
					"<?=CUtil::JSEscape($navigationBarID)?>",
					BX.CrmParamBag.create(<?=CUtil::PhpToJSObject($navigationBarConfig)?>)
				);
			}
		);
	</script><?

	if($isBitrix24Template)
	{
		$this->EndViewTarget();
	}
}
//endregion

$viewID = isset($arParams['~RENDER_INTO_VIEW']) ? $arParams['~RENDER_INTO_VIEW'] : '';
if($viewID === '')
{
	$viewID = $isBitrix24Template ? 'inside_pagetitle' : 'crm-grid-filter';
}

$this->SetViewTarget($viewID, 0);
//region Filter
?><div class="pagetitle-container pagetitle-flexible-space" style="overflow: hidden;"><?
$APPLICATION->IncludeComponent(
	'bitrix:main.ui.filter',
	'',
	[
		'GRID_ID' => $gridID,
		'FILTER_ID' => $filterID,
		'FILTER' => $arParams['~FILTER'],
		'FILTER_FIELDS' => $arParams['~FILTER_FIELDS'] ?? [],
		'FILTER_PRESETS' => $arParams['~FILTER_PRESETS'],
		'ENABLE_FIELDS_SEARCH' => (isset($arParams['~ENABLE_FIELDS_SEARCH']) && $arParams['~ENABLE_FIELDS_SEARCH'] === 'Y') ? 'Y' : 'N',
		'HEADERS_SECTIONS' => $arParams['~HEADERS_SECTIONS'] ?? [],
		'DISABLE_SEARCH' => isset($arParams['~DISABLE_SEARCH']) && $arParams['~DISABLE_SEARCH'] === true,
		'LAZY_LOAD' => $arParams['~LAZY_LOAD'] ?? null,
		'VALUE_REQUIRED_MODE' => isset($arParams['~VALUE_REQUIRED_MODE']) && $arParams['~VALUE_REQUIRED_MODE'] === true,
		'ENABLE_LIVE_SEARCH' => isset($arParams['~ENABLE_LIVE_SEARCH']) && $arParams['~ENABLE_LIVE_SEARCH'] === true,
		'LIMITS' => $arParams['~LIMITS'] ?? null,
		'ENABLE_LABEL' => true,
		'ENABLE_ADDITIONAL_FILTERS' => true,
		'CONFIG' => $arParams['~CONFIG'] ?? null,
		'THEME' => Bitrix\Main\UI\Filter\Theme::LIGHT,
	],
	$component
);
//endregion
?></div><?
$this->EndViewTarget();
