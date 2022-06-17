{"version":3,"sources":["extension.js"],"names":["SettingsChat","constructor","this","values","counterTypes","pushTypes","providerId","providerTitle","BX","message","providerSubtitle","getProviderId","getProviderTitle","getProviderSubtitle","getForm","Application","storage","getObject","quoteEnable","quoteFromRight","getApiVersion","historyShow","autoplayVideo","ChatPerformance","isAutoPlayVideoSupported","backgroundType","BackgroundType","lightGray","backgroundItems","type","hasOwnProperty","push","value","name","gestureQuoteOption","isGestureQuoteSupported","FormSection","create","addItems","FormItem","FormItemType","SWITCH","setValue","setEnabled","Form","addSections","SELECTOR","setSelectorItems","drawForm","form","provider","openForm","compile","getId","setFormItemValue","params","id","setObject","setSettingsProvider","onSettingsProviderButtonTap","item","onSettingsProviderValueChanged","sectionId","sectionCode","lightGreen","pink","creamy","dark","SettingsChatManager","addCustomEvent","isWebComponentSupported","SettingsNotifyProvider","SettingsProvider","onButtonTap","data","super","onValueChanged"],"mappings":"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","file":"extension.map.js"}