<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$bChecked = false;
if ($arResult['FILTER_VALUES'][$arParams['FILTER_NAME'].'_IS_ONLINE'])
{
	if ($key = array_search($arParams['FILTER_NAME'].'_IS_ONLINE', $arResult['FILTER_PARAMS'], true))
	{
		$bChecked = true;
		unset($arResult['FILTER_PARAMS'][$key]);
	}
}

$arParams['LIST_URL'] .= mb_strpos($arParams['LIST_URL'], '?') === false ? '?' : '&';

$extraUrl = 'set_filter_'.$arParams['FILTER_NAME'].'=Y'
	.GetFilterParams($arResult['FILTER_PARAMS'], true, $arExtraVars);

$onclick = 'window.location.href=\''.CUtil::JSEscape($arParams['LIST_URL'].$extraUrl).'\' + (this.checked ? \''.CUtil::JSEscape('&'.$arParams['FILTER_NAME'].'_IS_ONLINE=Y').'\' : \'\')';
?>
<input type="checkbox" name="<?echo $arParams['FILTER_NAME'].'_IS_ONLINE'?>" value="Y" <?echo $bChecked ? 'checked="checked"' : ''?> id="<?echo $arParams['FILTER_NAME'].'_IS_ONLINE'?>" title="<?echo GetMessage('ISS_TPL_ONLINE_TITLE')?>" onclick="<?echo htmlspecialcharsbx($onclick)?>" />
<label for="<?echo $arParams['FILTER_NAME'].'_IS_ONLINE'?>" title="<?echo GetMessage('ISS_TPL_ONLINE_TITLE')?>"><?echo GetMessage('ISS_TPL_ONLINE_LABEL')?></label>
