{"version":3,"sources":["task-quick-popups.js"],"names":["BX","Tasks","lwPopup","ajaxUrl","onTaskAdded","onTaskAddedMultiple","loggedInUserId","loggedInUserFormattedName","garbageAreaId","functions","functionsCount","firstRunDone","createForm","objPopup","objTemplate","callbacks","onAfterPopupCreated","onBeforePopupShow","onAfterPopupShow","onAfterEditorInited","onPopupClose","anyForm","anyFormsCount","registerForm","params","anyFormIndex","this","formIndex","__runAnyFormCallback","callbackName","args","Error","hasOwnProperty","apply","showForm","pData","oForm","__firstRun","isPopupJustCreated","buildForm","show","zIndexIn","zIndex","PopupWindow","autoHide","buttons","prepareButtons","closeByEsc","overlay","draggable","bindOnResize","titleBar","prepareTitleBar","closeIcon","right","top","events","onPopupFirstShow","onPopupShow","content","prepareContent","__runCreateFormCallback","showCreateForm","pTaskData","RESPONSIBLE_ID","parseInt","popupContainer","style","_createTask","onceMore","callbackOnSuccess","callbackOnFailure","columnsIds","taskData","TITLE","CJSTask","createItem","callback","oTask","precachedData","legacyDataFormat","legacyHtmlTaskItem","newDataPack","allowedTaskActions","allowedTaskActionsAsStrings","data","__initSelectors","arParams","cnt","length","bUserSelectorPresents","i","userSelectorAreaId","newFuncIndex","appendChild","create","props","id","ajaxData","sessid","message","requestsCount","sData","selectors","__prepareUserSelectorsData","__prepareGroupsSelectorsData","__prepareLheData","__prepareUserFieldData","key","__prepareUserFieldDataWebdav","ajax","method","dataType","url","processData","autoAuth","onsuccess","reply","innerHTML","onLoadedViaAjax","nameContainerId","dataContainerId","ajaxParams","requestedObject","userFieldName","taskId","values","newArr","push","allParams","ready","available","timeoutId","valuesBuffer","fieldLabel","remove","callbackOnRedraw","getValue","itemsIds","arItems","document","getElementsByName","value","setValue","cA","slice","sort","join","cB","__delayedSetContent","delay","window","clearTimeout","setTimeout","newDelay","urlParams","data_0","selfObj","html","rc","object","postData","UF_CRM_TASK","UF_TASK_WEBDAV_FILES","jsObjectName","elementId","inputId","editor","getContent","SaveContent","GetContent","setContent","type","isString","SetContent","ResizeSceleton","browser","IsChrome","IsIE11","IsIE","input","isElementNode","Focus","focus","addCustomEvent","attachTo","inited","attachToNode","dom","cont","CheckAndReInit","bindElement","bind","obj","e","event","oGroupObject","PreventDefault","setSelected","groupData","currentItem","selected","deselect","select","groupId","onSelectFunctionName","callbackOnSelect","arGroups","onSelectFuncName","userInputId","bindClickTo","GROUP_ID_FOR_SITE","selectedUsersIds","anchorId","multiple","nsObjectName","popupId","userPopupWindow","showUserSelector","onReady","objName","callbackOnReady","wait","timeout","O_USER_DATA","emp","arSelected","pop","searchInput","name","setSelectedUsers","selectedUsers","timeCalled","display","anchor","PopupWindowButton","text","btnSelectText","className","click","btnSelectClick","close","PopupWindowButtonLink","btnCancelText","PopupWindowManager","offsetTop","uniquePopupId","onUserSelect","arUser","arAllUsers","arAllUsersCount","arUsers","namespace","callbackOnChange","onUsersChange","onChangeFunctionName","_getDefaultTimeForInput","isDomNode","defaultTime","dtParts","toString","split","h","m","s","_showCalendar","node","field","bTime","bHideTime","callback_after","calendar","ui","getInputDateTimeValue","body","getElementsByTagName"],"mappings":"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","file":"task-quick-popups.map.js"}