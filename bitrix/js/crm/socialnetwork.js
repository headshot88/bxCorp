if(typeof(BX.CrmSocialnetworkIntegration) == 'undefined')
{
	BX.CrmSocialnetworkIntegration = function()
	{
		BX.addCustomEvent("BX.CommentAux.initialize", function() {
			if (typeof BX.CommentAux != 'undefined')
			{
				BX.CommentAux.postEventTypeList.push('CRM_LOG_CONTACT');
				BX.CommentAux.postEventTypeList.push('CRM_LOG_COMPANY');
				BX.CommentAux.postEventTypeList.push('CRM_LOG_LEAD');
				BX.CommentAux.postEventTypeList.push('CRM_LOG_DEAL');
				BX.CommentAux.postEventTypeList.push('CRM_ACTIVITY');
				BX.CommentAux.postEventTypeList.push('CRM_INVOICE');
				BX.CommentAux.commentEventTypeList.push('CRM_ENTITY_COMMENT');
			}
		});
	};

	BX.CrmSocialnetworkIntegration();
}
