<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true)
{
	die();
}

/** @var CBitrixComponentTemplate $this */
/** @var CBitrixComponent $component */
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */

$pageId = "group_forum";
include("util_group_menu.php");
include("util_group_profile.php");
?>
<?$arInfo = $APPLICATION->IncludeComponent("bitrix:socialnetwork.forum.topic.read", "", 
	Array(
		"FID"	=>	$arParams["FORUM_ID"],
		"TID"	=>	$arResult["VARIABLES"]["topic_id"],
		"MID"	=>	$arResult["VARIABLES"]["message_id"],
		"ACTION" => $arResult["VARIABLES"]["action"], 

		"SOCNET_GROUP_ID" => $arResult["VARIABLES"]["group_id"],
		"USER_ID" => $arResult["VARIABLES"]["user_id"],

		"URL_TEMPLATES_TOPIC_LIST"	=>	$arResult["~PATH_TO_GROUP_FORUM"],
		"URL_TEMPLATES_TOPIC"	=>	$arResult["~PATH_TO_GROUP_FORUM_TOPIC"],
		"URL_TEMPLATES_TOPIC_EDIT"	=>	$arResult["~PATH_TO_GROUP_FORUM_TOPIC_EDIT"],
		"URL_TEMPLATES_MESSAGE" =>  $arResult["~PATH_TO_GROUP_FORUM_MESSAGE"],
		"URL_TEMPLATES_PROFILE_VIEW"	=>	$arResult["~PATH_TO_USER"],

		"SHOW_VOTE" => $arParams["SHOW_VOTE"],
		"VOTE_CHANNEL_ID" => $arParams["VOTE_CHANNEL_ID"],
		"VOTE_TEMPLATE" => $arParams["VOTE_TEMPLATE"],

		"PAGEN" => $arParams["PAGEN"],
		"PAGE_NAVIGATION_TEMPLATE" =>  $arParams["PAGE_NAVIGATION_TEMPLATE"],
		"PAGE_NAVIGATION_WINDOW" =>  $arParams["PAGE_NAVIGATION_WINDOW"],
		"PAGE_NAVIGATION_SHOW_ALL" =>  $arParams["PAGE_NAVIGATION_SHOW_ALL"],

		"MESSAGES_PER_PAGE"	=>	$arParams["MESSAGES_PER_PAGE"],

		"WORD_LENGTH"	=>	$arParams["WORD_LENGTH"],
		"IMAGE_SIZE"	=>	$arParams["IMAGE_SIZE"],
		"DATE_FORMAT"	=>	$arParams["DATE_FORMAT"],
		"DATE_TIME_FORMAT"	=>	$arParams["DATE_TIME_FORMAT"],
		"NAME_TEMPLATE"	=> $arParams["NAME_TEMPLATE"],
		"USER_FIELDS" => $arParams["USER_FIELDS_FORUM"],

		"SHOW_RATING"	=>	$arParams["SHOW_RATING"],
		"RATING_ID"	=>	$arParams["RATING_ID"],
		"RATING_TYPE"	=>	$arParams["RATING_TYPE"],
		"SET_TITLE"	=>	$arParams["SET_TITLE"],
		"AJAX_POST" => 	$arParams["FORUM_AJAX_POST"],
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
	), 
	$component,
	array("HIDE_ICONS" => "Y"));
?><?
if (!empty($arInfo) && $arInfo["PERMISSION"] > "E" && !$arInfo["HideArchiveLinks"]):
?><div class='forum_post_form'><?$APPLICATION->IncludeComponent(
	"bitrix:socialnetwork.forum.post_form", 
	"", 
	Array(
		"FID"	=>	$arParams["FORUM_ID"],
		"TID"	=>	$arResult["VARIABLES"]["topic_id"],
		"MID"	=>	$arResult["VARIABLES"]["message_id"],
		"PAGE_NAME"	=>	"group_forum_message",
		"MESSAGE_TYPE"	=>	"REPLY",
		"bVarsFromForm" => $arInfo["bVarsFromForm"],
		
		"SOCNET_GROUP_ID" => $arResult["VARIABLES"]["group_id"],
		"USER_ID" => $arResult["VARIABLES"]["user_id"], 
		
		"URL_TEMPLATES_TOPIC_LIST" =>  $arResult["~PATH_TO_GROUP_FORUM_TOPIC"],
		"URL_TEMPLATES_MESSAGE" => $arResult["~PATH_TO_GROUP_FORUM_MESSAGE"],

		"SHOW_VOTE" => $arParams["SHOW_VOTE"],
		"VOTE_CHANNEL_ID" => $arParams["VOTE_CHANNEL_ID"],
		"VOTE_TEMPLATE" => $arParams["VOTE_TEMPLATE"],
		"USER_FIELDS" => $arParams["USER_FIELDS_FORUM"],

		"MESSAGE" => $arInfo["MESSAGE"],
		"ERROR_MESSAGE" => $arInfo["ERROR_MESSAGE"],
		
		"AJAX_TYPE" => $arParams["AJAX_TYPE"],
		"AJAX_POST" => $arParams["FORUM_AJAX_POST"],
		
		"CACHE_TYPE" => $arParams["CACHE_TYPE"],
		"CACHE_TIME" => $arParams["CACHE_TIME"],
		
		"SHOW_TAGS" => $arParams["SHOW_TAGS"]),
	$component,
	array("HIDE_ICONS" => "Y"));
?></div><?
endif;
?>