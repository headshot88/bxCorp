<?php
/**
 * @global  \CMain $APPLICATION
 */

require($_SERVER['DOCUMENT_ROOT'].'/bitrix/header.php');
IncludeModuleLangFile($_SERVER['DOCUMENT_ROOT'].'/bitrix/modules/intranet/public/timeman/meeting/index.php');
$APPLICATION->SetTitle(GetMessage('SERVICES_TITLE'));

?><?php
$APPLICATION->IncludeComponent('bitrix:meetings', '.default',
	[
		'RESERVE_MEETING_IBLOCK_TYPE' => 'events',
		'RESERVE_MEETING_IBLOCK_ID' => '#RESERVE_MEETING_IBLOCK_ID#',
		'RESERVE_VMEETING_IBLOCK_TYPE' => 'events',
		'RESERVE_VMEETING_IBLOCK_ID' => '#RESERVE_VMEETING_IBLOCK_ID#',
		'SEF_MODE' => 'Y',
		'SEF_FOLDER' => SITE_DIR.'timeman/meeting/',
		'SEF_URL_TEMPLATES' => [
			'list' => '',
			'meeting' => 'meeting/#MEETING_ID#/',
			'meeting_edit' => 'meeting/#MEETING_ID#/edit/',
			'meeting_copy' => 'meeting/#MEETING_ID#/copy/',
			'item' => 'item/#ITEM_ID#/',
		],
	],
	false
);
?><?php
require($_SERVER['DOCUMENT_ROOT'].'/bitrix/footer.php');