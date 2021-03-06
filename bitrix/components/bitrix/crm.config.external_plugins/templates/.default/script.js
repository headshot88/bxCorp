if (typeof(BX.CrmConfigExternalPlugins) === 'undefined')
{
	BX.CrmConfigExternalPlugins = function(settings)
	{
		this.settings = settings || {};
		this._getLinkBlock = this.settings.getLinkBlock || 'crm-config-external-plugins-linkblock';
		this._getLinkState = this.settings.getLinkState || 'crm-config-external-plugins-button-state';
		this._getLinkButton = this.settings.getLinkButton || 'crm-config-external-plugins-linkbutton';
		this._getLinkDelete = this.settings.getLinkDelete || 'crm-config-external-plugins-linkdelete';
		this._getLinkInput = this.settings.getLinkInput || 'crm-config-external-plugins-linkinput';
		this._getLinkCopy = this.settings.getLinkCopy || 'crm-config-external-plugins-linkcopy';
		this._ajaxPage = this.settings.ajaxPage || '/bitrix/components/bitrix/crm.config.external_plugins/ajax.php';

		BX.clipboard.bindCopyClick(BX(this._getLinkCopy), {text: BX(this._getLinkInput)});
		BX.bind(BX(this._getLinkButton), 'click', BX.delegate(this.getLink, this));
		BX.bind(BX(this._getLinkDelete), 'click', BX.delegate(this.delLink, this));
	};
	BX.CrmConfigExternalPlugins.prototype =
	{
		getLink: function()
		{
			this.saveLink(1, BX.delegate(function(){
				BX.toggleClass(BX(this._getLinkBlock), this._getLinkState);
			}, this));
		},
		delLink: function()
		{
			this.saveLink(0, BX.delegate(function(){
				BX.toggleClass(BX(this._getLinkBlock), this._getLinkState);
			}, this));
		},
		saveLink: function(enable, successCallback)
		{
			BX.showWait(BX(this._getLinkBlock));
			BX.ajax.loadJSON(
							this._ajaxPage,
							{
								cms: BX.data(BX(this._getLinkBlock), 'cms'),
								enable: enable,
								sessid: BX.bitrix_sessid()
							},
							BX.delegate(function(data){
								BX.closeWait(BX(this._getLinkBlock));
								if (data.error)
								{
									alert(data.error);
								}
								else
								{
									BX(this._getLinkInput).value = data.url;
									if (typeof successCallback !== 'undefined')
									{
										successCallback(data);
									}
								}
							}, this));
		}
	};
	BX.CrmConfigExternalPlugins._self = null;
	BX.CrmConfigExternalPlugins.create = function(settings)
	{
		if (this._self === null)
		{
			this._self = new this(settings);
		}
		return this._self;
	};
}