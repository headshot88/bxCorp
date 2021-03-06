BX.namespace("BX.Crm");

if(typeof BX.Crm.DialogButtonType === "undefined")
{
	BX.Crm.DialogButtonType =
	{
		undefined: 0,
		accept: 1,
		cancel: 2,

		names: { accept: "accept", cancel: "cancel" }
	};
}

if(typeof(BX.Crm.ConfirmationDialog) === "undefined")
{
	BX.Crm.ConfirmationDialog = function()
	{
		this._id = "";
		this._settings = null;
		this._confirmListener = BX.delegate(this.onConfirm, this);
		this._cancelListener = BX.delegate(this.onCancel, this);
		this._promise = null;

		this._isOpened = false;
	};
	BX.Crm.ConfirmationDialog.prototype =
	{
		initialize: function(id, settings)
		{
			this._id = id;
			this._settings = settings ? settings : {};
			this._popup = null;
		},
		getId: function()
		{
			return this._id;
		},
		isOpened: function()
		{
			return this._isOpened;
		},
		open: function()
		{
			if(this._isOpened)
			{
				return this._promise;
			}

			this._popup = new BX.PopupWindow(
				this._id,
				null,
				{
					autoHide: false,
					draggable: true,
					bindOptions: { forceBindPosition: false },
					closeByEsc: true,
					closeIcon: { top: "10px", right: "15px" },
					zIndex: 0,
					titleBar: BX.prop.getString(this._settings, "title", "untitled"),
					content: BX.prop.getString(this._settings, "content", "-"),
					className : "crm-text-popup",
					lightShadow : true,
					events:
					{
						onPopupShow: BX.delegate(this.onPopupShow, this),
						onPopupClose: BX.delegate(this.onPopupClose, this),
						onPopupDestroy: BX.delegate(this.onPopupDestroy, this)
					},
					buttons:
					[
						new BX.PopupWindowButton(
							{
								text : BX.message("JS_CORE_WINDOW_CONTINUE"),
								className : "popup-window-button-accept",
								events: { click: this._confirmListener }
							}
						),
						new BX.PopupWindowButtonLink(
							{
								text : BX.message("JS_CORE_WINDOW_CANCEL"),
								className : "popup-window-button-link-cancel",
								events: { click: this._cancelListener }
							}
						)
					]
				}
			);
			this._popup.show();
			return(this._promise = new BX.Promise());
		},
		close: function()
		{
			if(this._popup)
			{
				this._popup.close();
			}
		},
		onConfirm: function()
		{
			if(this._promise)
			{
				this._promise.fulfill({ cancel: false });
				this._promise = null;
			}
			this.close();
		},
		onCancel: function()
		{
			if(this._promise)
			{
				this._promise.fulfill({ cancel: true });
				this._promise = null;
			}
			this.close();
		},
		onPopupShow: function()
		{
			this._isOpened = true;
		},
		onPopupClose: function()
		{
			this._isOpened = false;
			if(this._popup)
			{
				this._popup.destroy();
			}
		},
		onPopupDestroy: function()
		{
			if(this._popup)
			{
				this._popup = null;
			}
		}
	};
	BX.Crm.ConfirmationDialog.items = {};
	BX.Crm.ConfirmationDialog.get = function(id)
	{
		return this.items.hasOwnProperty(id) ? this.items[id] : null;
	};
	BX.Crm.ConfirmationDialog.create = function(id, settings)
	{
		var self = new BX.Crm.ConfirmationDialog();
		self.initialize(id, settings);
		this.items[self.getId()] = self;
		return self;
	};
}

if(typeof(BX.Crm.NotificationDialog) === "undefined")
{
	BX.Crm.NotificationDialog = function()
	{
		this._id = "";
		this._settings = null;
		this._closeListener = BX.delegate(this.onClose, this);
		this._promise = null;
	};
	BX.Crm.NotificationDialog.prototype =
	{
		initialize: function(id, settings)
		{
			this._id = id;
			this._settings = settings ? settings : {};
			this._popup = null;
		},
		getId: function()
		{
			return this._id;
		},
		open: function()
		{
			this._popup = new BX.PopupWindow(
				this._id,
				null,
				{
					autoHide: false,
					draggable: true,
					bindOptions: { forceBindPosition: false },
					closeByEsc: true,
					closeIcon: { top: "10px", right: "15px" },
					zIndex: 0,
					titleBar: BX.prop.getString(this._settings, "title", "untitled"),
					content: BX.prop.getString(this._settings, "content", "-"),
					className : "crm-text-popup",
					lightShadow : true,
					events:
					{
						onPopupClose: BX.delegate(this.onPopupClose, this),
						onPopupDestroy: BX.delegate(this.onPopupDestroy, this)
					},
					buttons:
					[
						new BX.PopupWindowButtonLink(
							{
								text : BX.message("JS_CORE_WINDOW_CLOSE"),
								className : "popup-window-button-link-cancel",
								events: { click: this._closeListener }
							}
						)
					]
				}
			);
			this._popup.show();
			return(this._promise = new BX.Promise());
		},
		close: function()
		{
			if(this._popup)
			{
				this._popup.close();
			}
		},
		onClose: function()
		{
			if(this._promise)
			{
				this._promise.fulfill({});
				this._promise = null;
			}
			this.close();
		},
		onPopupClose: function()
		{
			if(this._popup)
			{
				this._popup.destroy();
			}
		},
		onPopupDestroy: function()
		{
			if(this._popup)
			{
				this._popup = null;
			}
		}
	};
	BX.Crm.NotificationDialog.items = {};
	BX.Crm.NotificationDialog.get = function(id)
	{
		return this.items.hasOwnProperty(id) ? this.items[id] : null;
	};
	BX.Crm.NotificationDialog.create = function(id, settings)
	{
		var self = new BX.Crm.NotificationDialog();
		self.initialize(id, settings);
		this.items[self.getId()] = self;
		return self;
	};
}