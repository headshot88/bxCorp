{"version":3,"sources":["script.js"],"names":["exports","main_core","main_popup","ui_dialogs_messagebox","_templateObject","_templateObject2","_templateObject3","_templateObject4","_templateObject5","_templateObject6","_templateObject7","_classPrivateMethodInitSpec","obj","privateSet","_checkPrivateRedeclaration","add","_classPrivateFieldInitSpec","privateMap","value","set","privateCollection","has","TypeError","_classPrivateMethodGet","receiver","fn","_groupAction","WeakMap","_renderGridRows","WeakSet","_renderQrButtons","_renderEntities","_renderActiveSwitchers","_getGrid","_getGridContainer","WebFormList","babelHelpers","classCallCheck","this","writable","createClass","key","init","params","_this","reloadGridTimeoutId","gridId","gridNode","document","getElementById","hideDescBtnNode","BX","bind","addClass","userOptions","delay","save","notifyBtnNode","_renderGridRows2","call","addCustomEvent","setGroupAction","code","classPrivateFieldSet","runGroupAction","classPrivateFieldGet","activateList","removeList","Error","concat","showConfirm","arguments","length","undefined","toUpperCase","Promise","resolve","reject","MessageBox","show","message","Loc","getMessage","modal","title","buttons","MessageBoxButtons","OK_CANCEL","onOk","messageBox","close","onCancel","reloadGrid","grid","_getGrid2","reload","showGridLoader","getLoader","hideGridLoader","hide","showNotification","UI","Notification","Center","notify","content","remove","id","_this2","then","ajax","runAction","json","response","data","_this3","removeSelected","resetCounters","_this4","checkOnWriteAccessError","result","copy","_this5","showSiteCode","Crm","Form","Embed","open","_this6","mode","list","getRows","getSelectedIds","activate","_this7","nodeText","switcher","Switcher","getById","setLoading","check","parseInt","textContent","isChecked","date","format","convertBitrixFormat","_this8","errors","forEach","error","_renderEntities2","_renderQrButtons2","_renderActiveSwitchers2","container","_getGridContainer2","switcherAttr","switchers","querySelectorAll","Array","prototype","slice","node","querySelector","JSON","parse","getAttribute","Qr","link","path","renderTo","attr","handler","event","stopPropagation","preventDefault","popup","PopupManager","getPopupById","getId","destroy","contentNode","Tag","render","taggedTemplateLiteral","counters","counter","counterHandler","SidePanel","Instance","LINK","caption","Text","encode","ENTITY_CAPTION","VALUE","counterNode","appendChild","popupWidth","create","className","closeByEsc","autoHide","bindElement","target","angle","offset","offsetLeft","offsetWidth","animation","width","padding","addEventListener","_this9","innerHTML","active","dateActiveShort","checked","color","handlers","toggled","Dom","removeClass","activatedBy","text","dateActiveFull","name","iconClass","iconPath","Main","gridManager","getInstanceById","getContainer","window","Dialogs"],"mappings":"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","file":"script.map.js"}