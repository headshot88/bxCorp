{"version":3,"sources":["script.js"],"names":["namespace","BX","Password","params","this","init","prototype","signedParameters","componentName","logoutButton","document","querySelector","type","isDomNode","bind","showConfirmLogoutPopup","logout","showErrorPopup","error","PopupWindowManager","create","id","content","props","style","html","closeIcon","lightShadow","offsetLeft","overlay","contentPadding","show","changePassword","loader","showLoader","node","size","ajax","runComponentAction","mode","data","then","response","hideLoader","Loader","target","hasOwnProperty","hide","cleanNode","block","getElementsByClassName","result","showSuccessPopup","confirmCallback","titleBar","message","contentColor","buttons","UI","CreateButton","text","className","events","click","context","close","CancelButton","onPopupClose","destroy","popup","PopupWindow","autoHide","closeByEsc","cacheable","width","Button","color","Color","PRIMARY","onclick"],"mappings":"CAAC,WAEA,IAAIA,EAAYC,GAAGD,UAAU,2BAC7B,GAAIA,EAAUE,SACd,CACC,OAGDF,EAAUE,SAAW,SAASC,GAE7BC,KAAKC,KAAKF,IAGXH,EAAUE,SAASI,WAClBD,KAAM,SAASF,GAEdC,KAAKG,iBAAmBJ,EAAOI,iBAC/BH,KAAKI,cAAgBL,EAAOK,cAE5B,IAAIC,EAAeC,SAASC,cAAc,sCAC1C,GAAIV,GAAGW,KAAKC,UAAUJ,GACtB,CACCR,GAAGa,KAAKL,EAAc,QAAS,WAC9BL,KAAKW,uBAAuBX,KAAKY,OAAOF,KAAKV,QAC5CU,KAAKV,SAITa,eAAgB,SAASC,GAExB,IAAKA,EACL,CACC,OAGDjB,GAAGkB,mBAAmBC,QACrBC,GAAI,oCACJC,QACCrB,GAAGmB,OAAO,OACTG,OACCC,MAAQ,oBAETC,KAAMP,IAERQ,UAAY,KACZC,YAAc,KACdC,WAAa,IACbC,QAAU,MACVC,eAAgB,KACdC,QAIJC,eAAgB,WAEf,IAAIC,EAAS7B,KAAK8B,YAAYC,KAAMlC,GAAG,8BAA+BgC,OAAQ,KAAMG,KAAM,MAE1FnC,GAAGoC,KAAKC,mBAAmBlC,KAAKI,cAAe,kBAC9CD,iBAAkBH,KAAKG,iBACvBgC,KAAM,OACNC,UACEC,KAAK,SAAUC,GACjB,GAAIA,EAASF,OAAS,KACtB,MAIA,CACCpC,KAAKuC,YAAYV,OAAQA,IACzB7B,KAAKa,eAAe,WAEnB,SAAUyB,GACZtC,KAAKuC,YAAYV,OAAQA,KACxBnB,KAAKV,QAGR8B,WAAY,SAAS/B,GAEpB,IAAI8B,EAAS,KAEb,GAAI9B,EAAOgC,KACX,CACC,GAAIhC,EAAO8B,SAAW,KACtB,CACCA,EAAS,IAAIhC,GAAG2C,QACfC,OAAQ1C,EAAOgC,KACfC,KAAMjC,EAAO2C,eAAe,QAAU3C,EAAOiC,KAAO,SAItD,CACCH,EAAS9B,EAAO8B,OAGjBA,EAAOF,OAGR,OAAOE,GAGRU,WAAY,SAASxC,GAEpB,GAAIA,EAAO8B,SAAW,KACtB,CACC9B,EAAO8B,OAAOc,OAGf,GAAI5C,EAAOgC,KACX,CACClC,GAAG+C,UAAU7C,EAAOgC,MAGrB,GAAIhC,EAAO8B,SAAW,KACtB,CACC9B,EAAO8B,OAAS,OAIlBjB,OAAS,WAER,IAAIiC,EAAQvC,SAASwC,uBAAuB,wBAC5C,IAAIjB,EAAS7B,KAAK8B,YAAYC,KAAMc,EAAM,GAAIhB,OAAQ,KAAMG,KAAM,MAElEnC,GAAGoC,KAAKC,mBAAmBlC,KAAKI,cAAe,UAC9CD,iBAAkBH,KAAKG,iBACvBgC,KAAM,OACNC,UACEC,KAAK,SAAUU,GACjB/C,KAAKuC,YAAYV,OAAQA,IACzB7B,KAAKgD,oBACJtC,KAAKV,MAAO,SAAU+C,GACvB/C,KAAKuC,YAAYV,OAAQA,KACxBnB,KAAKV,QAGRW,uBAAyB,SAASsC,GAEjCpD,GAAGkB,mBAAmBC,QACrBC,GAAI,+BACJiC,SAAUrD,GAAGsD,QAAQ,+CACrBjC,QACCrB,GAAGmB,OAAO,OACTG,OACCC,MAAQ,oBAETC,KAAMxB,GAAGsD,QAAQ,gDAEnB7B,UAAY,MACZC,YAAc,KACd6B,aAAc,QACd5B,WAAa,IACbC,QAAU,MACVC,eAAgB,GAChB2B,SACC,IAAIxD,GAAGyD,GAAGC,cACTC,KAAM3D,GAAGsD,QAAQ,kDACjBM,UAAW,uBACXC,QACCC,MAAO,WACN3D,KAAK4D,QAAQC,QACbZ,QAIH,IAAIpD,GAAGyD,GAAGQ,cACTN,KAAO3D,GAAGsD,QAAQ,gDAClBO,QACCC,MAAO,WACN3D,KAAK4D,QAAQC,aAKjBH,QACCK,aAAc,WAEb/D,KAAKgE,cAGLrC,QAGJqB,iBAAkB,WAEjB,IAAIiB,EAAQ,IAAIpE,GAAGqE,aAClBC,SAAU,KACVC,WAAY,KACZ9C,UAAW,KACX8B,aAAc,QACdF,SAAUrD,GAAGsD,QAAQ,+CACrBjC,QAASrB,GAAGmB,OAAO,OAClBG,OACCC,MAAQ,oBAETC,KAAMxB,GAAGsD,QAAQ,mDAElBkB,UAAW,MACXC,MAAO,IACPjB,SACC,IAAIxD,GAAGyD,GAAGiB,QACTf,KAAO3D,GAAGsD,QAAQ,wCAClBqB,MAAO3E,GAAGyD,GAAGiB,OAAOE,MAAMC,QAC1BC,QAAS,WACRV,EAAMJ,cAKVI,EAAMtC,UAhNR","file":"script.map.js"}