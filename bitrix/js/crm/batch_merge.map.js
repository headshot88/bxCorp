{"version":3,"sources":["batch_merge.js"],"names":["BX","namespace","Crm","BatchMergeManager","this","_id","_settings","_gridId","_entityTypeId","CrmEntityType","enumeration","undefined","_entityIds","_wrapper","_errors","_isRunning","_documentUnloadHandler","delegate","onDocumentUnload","_requestCompleteHandler","onRequestComplete","_externalEventHandler","prototype","initialize","id","settings","type","isNotEmptyString","Math","random","toString","substring","prop","getString","getInteger","container","isElementNode","create","appendChild","getId","getMessage","name","getObject","messages","getEntityIds","setEntityIds","entityIds","isArray","resetEntityIds","getErrors","execute","dialogId","toLowerCase","dialog","ConfirmationDialog","get","title","content","isOpened","open","then","result","getBoolean","startRequest","bind","isRunning","Main","gridManager","getInstanceById","tableFade","window","params","entityTypeId","extras","length","ajax","runAction","data","catch","response","tableUnfade","unbind","status","openMerger","errorInfos","getArray","i","push","displaySummary","setTimeout","complete","replace","concat","UI","Notification","Center","notify","join","position","autoHideDelay","_contextId","util","getRandomString","toUpperCase","Page","add_url_param","externalContextId","onExternalEvent","addCustomEvent","onCustomEvent","reload","e","returnValue","eventName","value","removeCustomEvent","items","getItem","self"],"mappings":"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","file":"batch_merge.map.js"}