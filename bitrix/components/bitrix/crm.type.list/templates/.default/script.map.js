{"version":3,"sources":["script.js"],"names":["exports","main_core","main_core_events","ui_dialogs_messagebox","namespace","Reflection","TypeListComponent","params","babelHelpers","classCallCheck","this","Type","isPlainObject","isString","gridId","BX","Main","grid","gridManager","getInstanceById","isElementNode","errorTextContainer","welcomeMessageContainer","isEmptyList","Boolean","createClass","key","value","init","bindEvents","_this","EventEmitter","subscribe","handleTypeDelete","bind","toolbarComponent","getToolbarComponent","subscribeTypeUpdatedEvent","event","isUrlChanged","isObject","getData","window","location","reload","getClass","Dom","removeClass","document","getElementById","showErrors","errors","text","forEach","message","innerText","parentElement","style","display","console","error","hideErrors","showErrorsFromResponse","_ref","messages","_ref2","push","_this2","id","Text","toInteger","data","Loc","getMessage","MessageBox","show","title","modal","buttons","MessageBoxButtons","YES_CANCEL","onYes","messageBox","ajax","runAction","analyticsLabel","then","response","reloadTable","catch","close","Crm","ToolbarComponent","Instance","Event","UI","Dialogs"],"mappings":"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","file":"script.map.js"}