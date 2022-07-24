{"version":3,"sources":["control-button.bundle.js"],"names":["this","BX","exports","main_core","main_popup","pull_client","main_core_events","_templateObject2","data","babelHelpers","taggedTemplateLiteral","_templateObject","ControlButton","params","arguments","length","undefined","classCallCheck","container","Type","isDomNode","entityType","entityId","items","mainItem","entityData","analyticsLabelParam","analyticsLabel","contextBx","window","top","sliderId","concat","Math","floor","random","isVideoCallEnabled","Reflection","getClass","Call","Util","isWebRTCSupported","chatLockCounter","isPlainObject","objectSpread","entity","buttonClassName","renderButton","subscribeEvents","createClass","key","value","destroy","Event","EventEmitter","unsubscribe","onCalendarSave","onPostSave","subscribe","bind","event","BaseEvent","getData","postEntityType","toUpperCase","sourceEntityType","sourceEntityId","sourceEntityData","responseData","entryId","addEntityComment","_event$getCompatData","getCompatData","_event$getCompatData2","slicedToArray","sliderEvent","getEventId","originatorSliderId","successPostId","isChatButton","onClickValue","openChat","startVideoCall","buttonTitle","Loc","getMessage","buttonClass","button","Tag","render","showMenu","Dom","append","showLoader","addClass","hideLoader","removeClass","getAvailableItems","_this","Promise","resolve","reject","availableItems","sessionStorage","getItem","ajax","runAction","then","response","setItem","_this2","filter","item","indexOf","menuItems","forEach","push","text","className","onclick","popupMenu","close","openTaskSlider","openCalendarSlider","openPostSlider","Menu","bindElement","offsetLeft","offsetTop","show","_this3","BXIM","openMessenger","parseInt","errors","code","showHintPopup","message","_this4","callTo","_this5","users","isArrayLike","userIds","map","userId","id","Calendar","SliderLoader","participantsEntityList","entryName","name","entryDescription","desc","_this6","SidePanel","Instance","open","link","requestMethod","requestParams","_this7","POST_TITLE","title","POST_MESSAGE","destTo","Popup","Text","getRandom","content","zIndex","angle","closeIcon","autoHide","darkMode","overlay","maxWidth","events","onAfterPopupShow","setTimeout","Intranet","Main"],"mappings":"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","file":"control-button.bundle.map.js"}