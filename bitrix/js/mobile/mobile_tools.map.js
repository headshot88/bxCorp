{"version":3,"sources":["mobile_tools.js"],"names":["window","BX","MobileTools","getTextBlock","block","decodeHtml","html","txt","document","createElement","innerHTML","value","text","replace","str","key1","key2","match","util","strip_tags","openChat","dialogId","dialogTitleParams","Application","BXMobileAppContext","getApiVersion","console","info","BXMobileApp","Events","postToComponent","name","avatar","color","description","PageManager","loadPageUnique","url","message","app","enableInVersion","bx24ModernStyle","data","phoneTo","number","params","this","canUseTelephony","callMethod","onCustomEvent","location","href","correctNumberForPstn","sheetButtons","push","title","callback","bind","UI","ActionSheet","buttons","show","callTo","userId","video","type","isNotEmptyString","length","substr","getMobileUrlParams","mobileRegReplace","exp","useNewStyle","useSearchBar","cache","i","mobileLink","Object","assign","getOpenFunction","resultOpenFunction","resolveList","resolveFunction","userIdFromUrl","openFunction","actionFromTaskActionUrl","taskIdFromUrl","userIdFromTaskEfficiencyUrl","diskFolderIdFromUrl","folderId","diskFileIdFromUrl","fileId","Document","open","projectIdFromUrl","siteId","siteDir","resolveData","inputData","apply","resolveOpenFunction","func","loadPageBlank","regs","reg","result","messageId","messageIdRes","parseInt","taskId","action","deadline","groupId","projectId","createCardScanner","options","scanner","onError","e","error","stripEmptyFields","imageData","onResult","onImageGet","exec","proxy","canceled","send","uploadOptions","FileUploadOptions","fileKey","fileName","mimeType","chunkedMode","image","ft","FileTransfer","upload","response","JSON","parse","UNIQUE_ID","STATUS","ERROR","addCustomEvent","handler","code","recognizeData","RESULT","removeCustomEvent","DATA","modifiedResult","CARD_ID","strippedResult","key","requestUserCounters","web","getDesktopStatus","Promise","resolve","responseHandler","unsubscribe","addEventListener","openDesktopPage","rest","pageViewEvents","onLiveFeedFavoriteView","onCalendarEventView","onTaskView","onTaskListView","onTaskCreate","onTaskEdit","onUserProfileView","onCRMInvoiceList","onCRMLeadList","onCRMDealList","onCRMContactList","onCRMActivityList","onCRMContactView","onCRMDealView","onCRMCompanyView","onCRMLeadView","onCRMQuoteView","onCRMProductView","onGroupView","onBizProcListView","getEventByUrl","eventName","originalLoadPageBlank","originalLoadPageStart","loadPageStart","originalShowModalDialog","showModalDialog","mwebrtc","origCallInvite","callInvite","arguments","fabric","Answers","sendCustomEvent","fixEventByUrl"],"mappings":"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","file":"mobile_tools.map.js"}