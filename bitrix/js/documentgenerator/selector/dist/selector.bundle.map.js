{"version":3,"sources":["selector.bundle.js"],"names":["this","BX","exports","main_loader","main_popup","main_core","Template","data","babelHelpers","classCallCheck","createClass","key","value","getId","parseInt","id","getName","name","create","Type","isPlainObject","isString","Document","getTitle","title","getPublicUrl","publicUrl","Menu","params","defineProperty","isDomNode","node","moduleId","provider","analyticsLabelPrefix","isNumber","isValid","length","isNil","createDocument","template","_this","Promise","resolve","reject","progress","showLoader","DocumentGenerator","askAboutUsingPreviousDocumentNumber","previousNumber","templateId","providerClassName","values","DocumentNumber","ajax","runAction","analyticsLabel","then","response","hideLoader","document","isArray","documents","unshift","getErrorMessageFromResponse","getDocumentPublicUrl","_this2","status","show","_this3","arguments","undefined","getTemplates","templates","PopupMenu","getPopupMenuId","prepareTemplatesList","object","menu","getMenuById","destroy","offsetLeft","offsetTop","closeByEsc","error","_this4","parseButtonResponse","getDocuments","_this5","select","filter","toLowerCase","order","forEach","push","_onclick","_this6","result","isDocumentsLimitReached","text","Loc","getMessage","className","onclick","showTariffPopup","isFunction","delimiter","selector","cacheable","events","onSubMenuShow","_this7","isSubmenuLoaded","submenu","getSubMenu","loadingItem","getMenuItem","getLayout","innerText","removeMenuItem","menuItems","addSubMenu","showSubMenu","items","_this8","errors","_ref","message","getLoader","loader","Loader","size","isShown","hide","_this9","getFeatureContent","content","getFeaturePopup","console","_this10","featurePopup","PopupWindow","zIndex","autoHide","closeIcon","overlay","onPopupDestroy","contentColor","_this11","featureContent","createElement","Runtime","html","htmlFirst","Selector","Main"],"mappings":"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","file":"selector.bundle.map.js"}