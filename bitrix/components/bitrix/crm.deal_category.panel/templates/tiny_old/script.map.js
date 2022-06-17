{"version":3,"sources":["script.js"],"names":["BX","CrmDealCategoryTinyPanel","this","_id","_settings","_items","_container","_selectorButton","_isCustomized","_counterId","_counterContainer","_counterMap","_enableCreation","_createUrl","_createLockScript","_nodes","_button","_menuId","_menu","prototype","initialize","id","settings","getSetting","containerId","type","isNotEmptyString","isElementNode","selectorButtonId","bind","delegate","onSelectorClick","addCustomEvent","onPullEvent","i","l","length","item","itemId","prop","getNumber","itemCounterCode","getString","getId","name","defaultval","hasOwnProperty","getMessage","m","messages","getItemById","convert","toNumber","createNewItem","window","location","href","eval","e","openMenu","onCreateButtonClick","closeMenu","menuItems","html","util","htmlspecialchars","counter","getInteger","itemUrl","add_url_param","IFRAME","IFRAME_TYPE","push","text","delimiter","onclick","PopupMenu","create","autoHide","closeByEsc","popupWindow","show","destroy","command","params","data","getObject","message","code","counterValue","innerHTML","self"],"mappings":"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","file":"script.map.js"}