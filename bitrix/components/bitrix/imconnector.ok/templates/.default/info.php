<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Localization\Loc;
use \Bitrix\ImConnector\Library;

if(
		!Library::isEmpty($arResult['INFO_CONNECTION']['NAME']) ||
		!Library::isEmpty($arResult['INFO_CONNECTION']['URL'])
):
?>
<div class="imconnector-field-container">
	<div class="imconnector-field-section">
		<div class="imconnector-field-main-title">
			<?=Loc::getMessage('IMCONNECTOR_COMPONENT_OK_INFO')?>
		</div>
		<div class="imconnector-field-box">
			<?
			if(!Library::isEmpty($arResult['INFO_CONNECTION']['NAME'])):
			?>
			<div class="imconnector-field-box-entity-row">
				<div class="imconnector-field-box-subtitle">
					<?=Loc::getMessage('IMCONNECTOR_COMPONENT_OK_GROUP_NAME')?>
				</div>
				<div class="imconnector-field-box-entity-text-bold">
					<?=htmlspecialcharsbx($arResult['INFO_CONNECTION']['NAME'])?>
				</div>
			</div>
			<?
			endif;
			if(!Library::isEmpty($arResult['INFO_CONNECTION']['URL'])):
			?>
			<div class="imconnector-field-box-entity-row">
				<div class="imconnector-field-box-subtitle">
					<?=Loc::getMessage('IMCONNECTOR_COMPONENT_OK_GROUP_LINK')?>
				</div>
				<a href="<?=htmlspecialcharsbx($arResult['INFO_CONNECTION']['URL'])?>"
				   class="imconnector-field-box-entity-link"
				   target="_blank">
					<?=htmlspecialcharsbx($arResult['INFO_CONNECTION']['URL'])?>
				</a>
				<span class="imconnector-field-box-entity-icon-copy-to-clipboard"
					  data-text="<?=htmlspecialcharsbx(CUtil::JSEscape($arResult['INFO_CONNECTION']['URL']))?>"></span>
			</div>
			<?endif;?>
		</div>
	</div>
</div>
<?endif;?>
