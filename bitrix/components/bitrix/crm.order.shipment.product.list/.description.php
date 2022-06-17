<?php
if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED!==true) die();

$arComponentDescription = array(
	'NAME' => GetMessage('CRM_ORDER_SHIPMENT_PRODUCT_LIST_NAME'),
	'DESCRIPTION' => GetMessage('CRM_ORDER_SHIPMENT_PRODUCT_LIST_DESCRIPTION'),
	'ICON' => '/images/icon.gif',
	'SORT' => 20,
	'PATH' => array(
		'ID' => 'crm',
		'NAME' => GetMessage('CRM_NAME'),
		'CHILD' => array(
			'ID' => 'order',
			'NAME' => GetMessage('CRM_ORDER_SHIPMENT_PRODUCT_LIST_NAME')
		)
	),
	'CACHE_PATH' => 'Y'
);
?>