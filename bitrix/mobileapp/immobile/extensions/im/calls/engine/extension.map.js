{"version":3,"sources":["extension.js"],"names":["blankAvatar","ajaxActions","createCall","createChildCall","getPublicChannels","getCall","pingTTLWebsocket","pingTTLPush","BX","Call","State","Incoming","UserState","Idle","Busy","Calling","Unavailable","Declined","Ready","Connecting","Connected","Failed","JoinStatus","None","Local","Remote","Type","Instant","Permanent","Provider","Plain","Voximplant","StreamTag","Main","Screen","Direction","Outgoing","Quality","VeryHigh","High","Medium","Low","VeryLow","UserMnemonic","all","none","Event","onUserInvited","onUserStateChanged","onUserMicrophoneState","onUserCameraState","onUserScreenState","onUserVoiceStarted","onUserVoiceStopped","onUserFloorRequest","onUserEmotion","onLocalMediaReceived","onLocalMediaStopped","onDeviceListUpdated","onRTCStatsReceived","onCallFailure","onStreamReceived","onStreamRemoved","onJoin","onLeave","onActive","onInactive","onDestroy","CallEngine","constructor","this","calls","unknownCalls","debugFlag","pullStatus","_onPullEventHandler","_onPullEvent","bind","_onPullClientEventHandler","_onPullClientEvent","addCustomEvent","onAppActive","e","status","console","log","CallUtil","getTimeForLog","_onCallJoinHandler","_onCallJoin","_onCallLeaveHandler","_onCallLeave","_onCallDestroyHandler","_onCallDestroy","_onCallInactiveHandler","_onCallInactive","_onCallActiveHandler","_onCallActive","_onNativeIncomingCallHandler","_onNativeIncomingCall","window","callservice","on","currentCall","setTimeout","startWithPush","postComponentEvent","callId","hasOwnProperty","PlainCall","ready","isNativeCall","Date","created","warn","destroy","push","Application","getLastNotification","id","startsWith","pushParams","JSON","parse","params","navigator","notification","alert","message","replace","ACTION","PARAMS","call","callFields","isVideo","video","ID","timestamp","ts","timeAgo","getTime","_onUnknownCallPing","then","result","autoAnswer","catch","err","error","shouldCallBeAutoAnswered","getPlatform","pushCallId","nativeCall","type","_instantiateCall","users","logToken","isNative","config","Promise","resolve","reject","callType","callProvider","provider","joinExisting","associatedEntity","entityType","entityId","isNew","callParameters","userIds","isArray","getRestClient","callMethod","response","getError","code","error_description","createCallResponse","data","userData","publicChannels","PULL","setPublicIds","Object","values","CallStub","callFactory","_getCallFactory","parseInt","instanceId","getUuidv4","direction","videoEnabled","enableMicAutoParameters","ASSOCIATED_ENTITY","events","debug","_getCallFields","joinStatus","answer","getCallWithId","END_DATE","c","r","Math","random","v","toString","apply","arguments","rest","getLogService","componentParameters","get","isCallServerAllowed","command","extra","handlers","_onPullIncomingCall","publicIds","server_time_ago","PROVIDER","parentId","PARENT_ID","callFromMobile","isLegacyMobile","initiatorId","senderId","TYPE","startDate","START_DATE","addInvitedUsers","invitedUsers","serverTimeAgo","ttl","env","userId","providerType","PlainCallFactory","VoximplantCallFactory","Error","off","onDelete","removeCustomEvent","VoximplantCall","lifetime","callbacks","isFunction","deleteTimeout","isAnyoneParticipating","addEventListener","removeEventListener","clearTimeout","CCallUtil","usersInProcess","updateUserData","usersToUpdate","i","length","isPlainObject","forEach","getUsers","setUserData","getDateForLog","d","getFullYear","lpad","getMonth","getDate","getHours","getMinutes","getSeconds","getMilliseconds","getLogMessage","formatSeconds","timeInSeconds","floor","seconds","minutes","str","chr","isAvatarBlank","url","endsWith","makeAbsolute","currentDomain","getCustomMessage","messageText","gender","convertKeysToUpper","match","placeHolder","substr","getUserLimit","text","stack","printObject","obj","key","val","debounce","fn","timeout","ctx","timer","array_flip","inputObject","isDeviceSupported","getApiVersion","forceBackgroundConnectPull","timeoutSeconds","callEngine","onConnectTimeout","onPullStatus","connectionTimeout","additional","isError","showDeviceAccessConfirm","withVideo","acceptCallback","declineCallback","confirm","button","DeviceAccessError","justDenied","super","name","CallJoinedElseWhereError"],"mappings":"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","file":"extension.map.js"}