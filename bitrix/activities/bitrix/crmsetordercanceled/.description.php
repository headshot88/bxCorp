<?
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();

$arActivityDescription = array(
	"NAME" => GetMessage("CRM_SOCCL_DESCR_NAME"),
	"DESCRIPTION" => GetMessage("CRM_SOCCL_DESCR_DESCR"),
	"TYPE" => array("activity", "robot_activity"),
	"CLASS" => "CrmSetOrderCanceled",
	"JSCLASS" => "BizProcActivity",
	"CATEGORY" => array(
		"ID" => "document",
		"OWN_ID" => 'crm',
		"OWN_NAME" => 'CRM',
	),
	'FILTER' => array(
		'INCLUDE' => array(
			['crm', 'Bitrix\Crm\Integration\BizProc\Document\Order']
		),
	),
	'ROBOT_SETTINGS' => array(
		'CATEGORY' => 'employee'
	),
);