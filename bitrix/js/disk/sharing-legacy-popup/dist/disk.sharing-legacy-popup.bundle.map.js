{"version":3,"sources":["disk.sharing-legacy-popup.bundle.js"],"names":["this","BX","Disk","exports","main_core","ui_buttons","LegacyPopup","babelHelpers","classCallCheck","defineProperty","createClass","key","value","showSharingDetailWithChangeRights","params","_this","entityToNewShared","loadedReadOnlyEntityToNewShared","objectId","object","id","modalWindowLoader","addToLinkParam","ajaxUrl","responseType","postData","afterSuccessLoad","response","status","errors","showModalWithStatusAction","message","pop","objectOwner","name","owner","avatar","link","modalWindow","modalId","title","contentClassName","contentStyle","events","onAfterPopupShow","addCustomEvent","onChangeRightOfSharing","bind","i","members","hasOwnProperty","entityId","item","type","right","SocNetLogDestination","init","destFormName","searchInput","bindMainPopup","node","offsetTop","offsetLeft","bindSearchPopup","callback","select","onSelectDestination","unSelect","onUnSelectDestination","openDialog","onOpenDialogDestination","closeDialog","onCloseDialogDestination","openSearch","onOpenSearchDestination","closeSearch","onCloseSearchDestination","items","destination","itemsLast","itemsSelected","BXSocNetLogDestinationFormName","e","PreventDefault","onKeyUpDestination","onKeyDownDestination","onPopupClose","isOpenDialog","removeCustomEvent","content","create","props","className","children","html","Text","encode","style","background","href","text","click","buttons","SaveButton","ajax","method","dataType","url","data","onsuccess","replace","PopupWindowManager","getCurrentPopup","close","UI","CloseButton","showSharingDetailWithSharing","_this2","entityToNewSharedMaxTaskName","maxTaskName","clone","showSharingDetailWithoutEdit","search","appendNewShared","readOnly","child","findChild","attribute","data-dest-id","remove","taskName","focus","popupWindow","adjustPosition","forceTop","input","isOpenSearch","length","popupSearchWindow","event","keyCode","sendEvent","deleteLastItem","selectFirstSearchItem","SharingControlType","Sharing"],"mappings":"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","file":"disk.sharing-legacy-popup.bundle.map.js"}