<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

if (defined("WIZARD_IS_RERUN") && WIZARD_IS_RERUN === true)
	return;

if(!CModule::IncludeModule("fileman"))
	return;

$APPLICATION->SetGroupRight("fileman", WIZARD_EXTRANET_ADMIN_GROUP, "F");
?>