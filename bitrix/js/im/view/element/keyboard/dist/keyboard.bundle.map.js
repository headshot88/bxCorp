{"version":3,"sources":["keyboard.bundle.js"],"names":["exports","ui_vue","im_lib_utils","im_lib_logger","_ButtonType","Object","freeze","newline","button","BitrixVue","component","props","buttons","type","Array","default","_default","messageId","userId","dialogId","data","isMobile","Utils","platform","isBlocked","localButtons","created","this","prepareButtons","watch","clearTimeout","recoverStateButton","methods","click","_this","DISABLED","ACTION","ACTION_VALUE","toString","$emit","action","params","botId","BOT_ID","value","FUNCTION","execFunction","replace","eval","APP_ID","Logger","warn","LINK","isBitrixMobile","app","openNewPage","window","open","WAIT","BLOCK","command","COMMAND","COMMAND_PARAMS","setTimeout","getStyles","styles","WIDTH","DISPLAY","BG_COLOR","TEXT_COLOR","filter","CONTEXT","computed","ButtonType","template","BX","Messenger","Lib"],"mappings":"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","file":"keyboard.bundle.map.js"}