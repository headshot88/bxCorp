{"version":3,"sources":["extension.js"],"names":["DoNothing","defaultConnectionOptions","OfferToReceiveAudio","OfferToReceiveVideo","signalingWaitReplyPeriod","pingPeriod","backendPingPeriod","reinvitePeriod","ajaxActions","Object","freeze","invite","cancel","answer","decline","hangup","ping","negotiationNeeded","connectionOffer","connectionAnswer","iceCandidate","PullEvents","voiceStarted","voiceStopped","microphoneState","cameraState","videoPaused","userInviteTimeout","repeatAnswer","PlainCall","constructor","params","this","id","instanceId","parentId","direction","associatedEntity","userId","parseInt","env","initiatorId","users","BX","type","isArray","filter","ready","_joinStatus","Call","JoinStatus","None","defineProperty","get","getJoinStatus","bind","set","setJoinStatus","_active","getActive","setActive","localStream","videoEnabled","muted","peers","signaling","Signaling","call","logToken","callEngine","getLogService","logger","CallLogger","eventEmitter","JNEventEmitter","events","eventName","hasOwnProperty","on","pingUsersInterval","setInterval","pingUsers","pingBackendInterval","pingBackend","lastPingReceivedTimeout","created","Date","initPeers","forEach","push","createPeer","inviteUsers","config","map","peer","length","Error","getLocalMedia","then","getSignaling","userIds","video","response","i","getPeer","onInvited","joinStatus","Local","Peer","onStreamReceived","track","log","kind","emit","Event","onStreamRemoved","e","onStateChanged","_onPeerStateChanged","onInviteTimeout","_onPeerInviteTimeout","find","getUsers","result","calculatedState","newStatus","onJoin","callId","local","Remote","onLeave","newActive","active","onActive","onInactive","isVideoEnabled","setVideoEnabled","getVideoTracks","MediaDevices","startCapture","replaceMedia","onLocalMediaReceived","stopCapture","onLocalMediaStopped","sendCameraState","setVideoPaused","toString","enabled","sendVideoPaused","switchCamera","switchVideoSource","isFrontCameraUsed","cameraDirection","setMuted","audioTracks","getAudioTracks","sendMicrophoneState","isMuted","text","CallUtil","getLogMessage","apply","arguments","console","debugFlag","a","getTimeForLog","concat","Array","prototype","slice","event","handler","off","Promise","resolve","getUserMedia","audio","stream","isReady","sendLocalStream","sendMedia","isPlainObject","Direction","Incoming","useVideo","enableMicAutoParameters","reject","CallJoinedElseWhereError","sendAnswer","onCallFailure","addInvitedUsers","UserState","Failed","Idle","includes","onUserInvited","isAnyoneParticipating","some","isParticipating","code","reason","data","callInstanceId","getRestClient","callMethod","destroy","error","tempError","name","stack","disconnect","sendHangup","sendPingToUsers","sendPingToBackend","repeatAnswerEvents","sendRepeatAnswer","runCallback","_onPullEvent","command","extra","handlers","_onPullEventAnswer","_onPullEventHangup","_onPullEventPing","_onPullEventNegotiationNeeded","_onPullEventConnectionOffer","_onPullEventConnectionAnswer","_onPullEventIceCandidate","_onPullEventVoiceStarted","_onPullEventVoiceStopped","_onPullEventMicrophoneState","_onPullEventVideoPaused","_onPullEventUsersJoined","_onPullEventUsersInvited","_onPullEventUserInviteTimeout","_onPullEventAssociatedEntityReplaced","_onPullEventFinish","_onPullEventRepeatAnswer","JSON","stringify","senderId","_onPullEventAnswerSelf","setSignalingConnected","setReady","isLegacyMobile","setDeclined","clearTimeout","setTimeout","_onNoPingsReceived","restart","reconnect","onNegotiationNeeded","setUserAgent","userAgent","setConnectionOffer","connectionId","sdp","tracks","setConnectionAnswer","candidates","addIceCandidate","onUserMicrophoneState","onUserVideoPaused","failedUserId","onUserStateChanged","state","previousState","Unavailable","catch","Connected","stopStreaming","reinviteTimeout","onDestroy","calling","inviteTimeout","declined","busy","peerConnection","pendingIceCandidates","localIceCandidates","trackList","_incomingVideoTrack","_incomingScreenTrack","callbacks","isFunction","onRTCStatsReceived","_onPeerConnectionIceCandidateHandler","_onPeerConnectionIceCandidate","_onPeerConnectionIceConnectionStateChangeHandler","_onPeerConnectionIceConnectionStateChange","_onPeerConnectionIceGatheringStateChangeHandler","_onPeerConnectionIceGatheringStateChange","_onPeerConnectionNegotiationNeededHandler","_onPeerConnectionNegotiationNeeded","_onPeerConnectionTrackHandler","_onPeerConnectionTrack","_onPeerConnectionRemoveTrackHandler","_onPeerConnectionRemoveTrack","_onPeerConnectionAddStreamHandler","_onPeerConnectionAddStream","_onPeerConnectionRemoveStreamHandler","_onPeerConnectionRemoveStream","_onPeerConnectionSignalingStateChangeHandler","_onPeerConnectionSignalingStateChange","answerTimeout","callingTimeout","connectionTimeout","signalingConnectionTimeout","candidatesTimeout","connectionAttempt","updateCalculatedState","internal","signalingConnected","isInitiator","calculateState","iceConnectionState","Connecting","failureReason","Calling","Declined","Busy","Ready","isRenegotiationSupported","sendIceCandidates","sendIceCandidate","_id","getUuidv4","_createPeerConnection","getTracks","addTrack","createAndSendOffer","sendNegotiationNeeded","updateOutgoingTracks","videoTrack","audioTrack","videoSender","getSenders","sender","removeTrack","audioSender","negotiationNeededReplyTimeout","array_flip","_destroyPeerConnection","applyOfferAndSendAnswer","connectionConfig","assign","createOffer","offer","pendingLocalDescription","sendOffer","connectionOfferReplyTimeout","_onConnectionOfferReplyTimeout","sendConnectionOffer","signalingState","iceRestart","_onNegotiationNeededReplyTimeout","sessionDescription","setRemoteDescription","createAnswer","setLocalDescription","applyPendingIceCandidates","sendConnectionAnswer","localDescription","maybeSetPendingLocalOffer","err","candidate","remoteDescription","updateCandidatesTimeout","reconnectAfterDisconnectTimeout","trace","turnServer","componentParameters","turnServerLogin","turnServerPassword","iceServers","urls","username","credential","RTCPeerConnection","JNRTCPeerConnection","Events","IceCandidate","IceConnectionStateChange","IceGatheringStateChange","NegotiationNeeded","Track","RemoveTrack","AddStream","RemoveStream","SignalingStateChange","close","_hasIncomingVideo","getTransceivers","tr","currentDirection","receiver","getPublishingState","_getTrackMid","trackId","mid","screenTrack","incomingScreenTrack","incomingVideoTrack","stopSignalingTimeout","refreshSignalingTimeout","_onLostSignalingConnection","signalingConnectionRefreshPeriod","isIceTricklingAllowed","isPublishingSupported","PULL","__runRestAction","repeated","__sendPullEventOrCallRest","sendVoiceStarted","sendVoiceStopped","__sendPullEvent","retransmit","sendUserInviteTimeout","dataForRest","restMethod","expiry","requestId","sendMessage","signalName","window","PlainCallPeer"],"mappings":"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","file":"extension.map.js"}