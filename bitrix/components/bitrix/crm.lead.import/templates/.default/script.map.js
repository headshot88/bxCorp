{"version":3,"sources":["script.js"],"names":["crmImportStep","step","form_id","selectTab","arDisable","Array","splice","bxForm","eval","SelectTab","elDisable","ShowDisabledTab","BX","className","crmImportAjax","importUrl","ajax","url","util","add_url_param","import","method","dataType","data","onsuccess","parseInt","style","display","height","i","tableRow","create","tableRowColumn","props","colSpan","innerHTML","appendChild","ii","text","href","type","isNotEmptyString","disabled","hidden","complete_import","onfailure","CrmFileImportConfig","this","_id","_settings","_dupControlTypeDescr","_dupControlTypes","prototype","initialize","id","settings","dupControlPrefix","getSetting","key","hasOwnProperty","element","toLowerCase","bind","delegate","_onDupControlTypeChange","name","defaultval","e","window","event","target","getEventTarget","value","htmlspecialchars","self"],"mappings":"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","file":""}