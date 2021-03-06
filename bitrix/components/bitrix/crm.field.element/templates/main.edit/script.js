/**
 * copy from here main/install/components/bitrix/system.field.edit/templates/crm/script.js
 * need refactoring!
 */

BX.CrmElementEntitySelector = (function ()
{
	var CrmElementEntitySelector = function (parameters)
	{
		this.randomString = parameters.randomString;
		this.jsObject = parameters.jsObject;
		this.fieldUid = parameters.fieldUid;
		this.fieldName = parameters.fieldName;
		this.usePrefix = parameters.usePrefix;
		this.listPrefix = parameters.listPrefix;
		this.selectorEntityTypes = parameters.selectorEntityTypes;
		this.multiple = parameters.multiple;
		this.listElement = parameters.listElement;
		this.listEntityType = parameters.listEntityType;
		this.pluralCreation = Boolean(parameters.pluralCreation);
		this.listEntityCreateUrl = parameters.listEntityCreateUrl;
		this.currentEntityType = parameters.currentEntityType;
		this.context = parameters.context;
		this.dynamicTypeTitles = parameters.dynamicTypeTitles;

		this.initialize();
	};

	CrmElementEntitySelector.prototype.initialize = function()
	{
		this.popupObject = null;
		this.popupId = 'crm-'+this.randomString+'-popup';
		this.popupBindElement = null;
		this.popupContent = '';
		this.externalRequestData = null;
		this.externalEventHandler = null;

		BX.addCustomEvent('onCrmSelectedItem', BX.proxy(this.setSelectedElement, this));
		BX.addCustomEvent('onCrmUnSelectedItem', BX.proxy(this.unsetSelectedElement, this));
	};

	CrmElementEntitySelector.prototype.createNewEntity = function(event)
	{
		if(this.pluralCreation)
		{
			event = event || window.event;
			this.popupBindElement = event.currentTarget;
			this.createPopup();
		}
		else
		{
			this.performExternalRequest();
		}
	};

	CrmElementEntitySelector.prototype.performExternalRequest = function(entityType)
	{
		if(this.popupObject)
		{
			this.popupObject.popupWindow.close();
		}

		if(entityType)
		{
			this.setCurrentEntityType(entityType);
		}

		var url = BX.util.add_url_param(this.getCreateUrl(), {
			external_context: this.context
		});

		BX.SidePanel.Instance.open(url);

		if(!this.externalRequestData)
		{
			this.externalRequestData = {};
		}

		this.externalRequestData[this.context] = {
			context: this.context,
			url: url
		};

		if(!this.externalEventHandler)
		{
			this.externalEventHandler = BX.delegate(this.onExternalEvent, this);
			BX.addCustomEvent(window, 'onLocalStorageSet', this.externalEventHandler);
		}
	};

	CrmElementEntitySelector.prototype.onExternalEvent = function(params)
	{
		var key = BX.type.isNotEmptyString(params['key']) ? params['key'] : '';
		var value = BX.type.isPlainObject(params['value']) ? params['value'] : {};
		var typeName = BX.type.isNotEmptyString(value['entityTypeName']) ? value['entityTypeName'] : '';
		var context = BX.type.isNotEmptyString(value['context']) ? value['context'] : '';

		if(
			key === 'onCrmEntityCreate'
			&& typeName === this.currentEntityType.toUpperCase()
			&& this.externalRequestData &&
			BX.type.isPlainObject(this.externalRequestData[context])
		)
		{
			var isCanceled = BX.type.isBoolean(value['isCanceled']) ? value['isCanceled'] : false;
			if(!isCanceled && BX.type.isPlainObject(value['entityInfo']))
			{
				var selector = BX.UI.SelectorManager.instances[this.fieldUid];
				var valueEntityType = value.entityInfo.type.toUpperCase();

				if (BX.type.isNotEmptyObject(selector))
				{
					var selectedItems = {};
					if(this.multiple === 'Y')
					{
						for(var code in selector.itemsSelected)
						{
							if (!selector.itemsSelected.hasOwnProperty(code))
							{
								continue;
							}
							selectedItems[code] = selector.itemsSelected[code];
						}
					}
					selectedItems[this.listPrefix[valueEntityType] + '_' + value.entityInfo.id] = this.selectorEntityTypes[valueEntityType];

					BX.onCustomEvent("BX.Main.SelectorV2:reInitDialog", [ {
						selectorId: this.fieldUid,
						selectedItems: selectedItems
					} ]);
				}
			}

			if(this.externalRequestData[context]['url'])
			{
				var slider = BX.SidePanel.Instance.getSlider(this.externalRequestData[context]['url']);
				if (slider)
				{
					slider.destroy();
				}
			}

			delete this.externalRequestData[context];
		}
	};

	CrmElementEntitySelector.prototype.createPopup = function()
	{
		var popupItems = [];
		var text = '';
		for(var k in this.listEntityType)
		{
			// @todo show smart-processes too
			if (this.listEntityType[k].toUpperCase().indexOf('DYNAMIC_') === 0)
			{
				text = this.dynamicTypeTitles['DYNAMICS_' + k];
			}
			else
			{
				text = BX.message('CRM_ELEMENT_CREATE_'+this.listEntityType[k].toUpperCase());
				popupItems.push({
					text : text,
					onclick : 'BX["'+this.jsObject+'"].performExternalRequest("'+this.listEntityType[k]+'");'
				});
			}
		}

		if(!BX.PopupMenu.getMenuById(this.popupId))
		{
			var buttonRect = this.popupBindElement.getBoundingClientRect();
			this.popupObject = BX.PopupMenu.create(
				this.popupId,
				this.popupBindElement,
				popupItems,
				{
					closeByEsc : true,
					angle: true,
					offsetLeft: buttonRect.width/2
				}
			);
		}
		if(this.popupObject)
		{
			this.popupObject.popupWindow.show();
		}
	};

	CrmElementEntitySelector.prototype.setCurrentEntityType = function(currentEntityType)
	{
		this.currentEntityType = currentEntityType;
	};

	CrmElementEntitySelector.prototype.getCreateUrl = function()
	{
		if(this.listEntityCreateUrl.hasOwnProperty(this.currentEntityType))
		{
			return this.listEntityCreateUrl[this.currentEntityType];
		}
		else
		{
			return '';
		}
	};

	CrmElementEntitySelector.prototype.setSelectedElement = function(itemInfo)
	{
		for (var k in this.listElement)
		{
			if (itemInfo.id === this.listElement[k].id)
			{
				this.listElement[k].selected = 'Y';
			}
		}
	};

	CrmElementEntitySelector.prototype.unsetSelectedElement = function(itemInfo)
	{
		for (var k in this.listElement)
		{
			if (itemInfo.id === this.listElement[k].id)
			{
				this.listElement[k].selected = 'N';
			}
		}
	};

	CrmElementEntitySelector.prototype.initWidgetEntitySelection = function()
	{
		BX.loadCSS('/bitrix/js/crm/css/crm.css');

		if(typeof(CRM) == 'undefined')
		{
			BX.loadScript('/bitrix/js/crm/crm.js', BX[''+this.jsObject+''].initWidgetEntitySelection());
			return;
		}

		CRM.Set(
			BX('crm-'+this.fieldUid+'-open'),
			this.fieldName,
			'',
			this.listElement,
			(this.usePrefix === 'Y'),
			(this.multiple === 'Y'),
			this.listEntityType,
			{
				'lead': BX.message('CRM_ELEMENT_LEAD'),
				'contact': BX.message('CRM_ELEMENT_CONTACT'),
				'company': BX.message('CRM_ELEMENT_COMPANY'),
				'deal': BX.message('CRM_ELEMENT_DEAL'),
				'quote': BX.message('CRM_ELEMENT_QUOTE'),
				'order': BX.message('CRM_ELEMENT_ORDER'),
				'ok': BX.message('CRM_ELEMENT_OK'),
				'cancel': BX.message('CRM_ELEMENT_CANCEL'),
				'close': BX.message('CRM_ELEMENT_CLOSE'),
				'wait': BX.message('CRM_ELEMENT_SEARCH'),
				'noresult': BX.message('CRM_ELEMENT_NO_RESULT'),
				'add': BX.message('CRM_ELEMENT_CHOISE'),
				'edit': BX.message('CRM_ELEMENT_CHANGE'),
				'search': BX.message('CRM_ELEMENT_SEARCH'),
				'last': BX.message('CRM_ELEMENT_LAST')
			}
		);
	};

	return CrmElementEntitySelector;
})();
