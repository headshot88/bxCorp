{"version":3,"file":"script.min.js","sources":["script.js"],"names":["BX","namespace","Crm","showModalWithStatusAction","response","action","message","status","this","getFirstErrorFromResponse","messageBox","create","props","className","children","text","currentPopup","PopupWindowManager","getCurrentPopup","destroy","idTimeout","setTimeout","w","uniquePopupId","close","popupConfirm","content","onPopupClose","clearTimeout","autoHide","zIndex","show","onmouseover","e","onmouseout","reponse","errors","shift","ProductSectionCrumbsClass","parameters","containerId","catalogId","sectionId","crumbs","componentId","collapsedCrumbs","childrenCrumbs","showOnlyDeleted","jsEventsMode","container","isExternalSectionSelectDisabled","isSelectSectionEventDisabled","ajaxUrl","jsEventsManagerId","jsEventsManager","style","opacity","buildCrumbs","registerEventHandler","delegate","onExternalSectionSelect","prototype","setEvents","bindDelegate","tag","proxy","onClickArrow","bind","onClickDots","unsetEvents","unbindAll","expand","crumb","arrow","items","objectId","getAttribute","PopupMenu","angle","offset","events","event","menu","getMenuById","popupWindow","arrowTarget","srcElement","target","findParent","isRoot","reloadCrumbs","ajax","method","dataType","url","data","urlTemplate","sessid","bitrix_sessid","onsuccess","onSectionSelect","params","fireEvent","hasOwnProperty","showedItems","menuItem","i","j","cleanCrumbs","Array","splice","length","util","htmlspecialchars","menuId","onClickCrumbLink","appendChild","attrs","id","push","class","data-isRoot","parseInt","data-objectId","data-objectName","click","html","href","type","isDomNode","cleanNode","getEventTarget","sectionName"],"mappings":"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"}