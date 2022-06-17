<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)
	die();

$arFilter = Array(
	"ACTIVE"	=>	"Y",
);
$rsMess = CEventMessage::GetList("id", "desc", $arFilter);

$arMess = array();

while ($arMessage  = $rsMess->Fetch())
{
	if ($arMessage["EVENT_NAME"] == "SONET_NEW_MESSAGE")
		continue;

	$str_LID = array();

	$db_LID = CEventMessage::GetLang($arMessage["ID"]);
	while($ar_LID = $db_LID->Fetch())
		$str_LID[] = $ar_LID["LID"];

	if (!in_array(WIZARD_SITE_ID, $str_LID))
		$str_LID[] = WIZARD_SITE_ID;

	$arMess[] = array(
		"ID" => $arMessage["ID"],
		"ACTIVE" => $arMessage["ACTIVE"],		
		"LID" => $str_LID
	);
}

$em = new CEventMessage;
foreach ($arMess as $arM)
{
	$arFields = Array(
		"ACTIVE" => $arM["ACTIVE"],	
		"LID" => $arM["LID"],
	);

	$res = $em->Update($arM["ID"], $arFields);
}

$em->Add(array(
	"ACTIVE" => "Y",
	"EVENT_NAME" => "SONET_NEW_MESSAGE",
	"LID" => array(WIZARD_SITE_ID),
	"EMAIL_FROM" => "#DEFAULT_EMAIL_FROM#",
	"EMAIL_TO" => "#EMAIL_TO#",
	"SUBJECT" => GetMessage("EXTRANET_NEW_MESSAGE_SUBJECT"),
	"MESSAGE" => str_replace("/company/personal/", WIZARD_SITE_DIR."contacts/personal/", GetMessage("EXTRANET_NEW_MESSAGE_MESSAGE")),
	"BODY_TYPE" => "text",
));

?>