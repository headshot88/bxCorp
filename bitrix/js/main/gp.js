function gpLevel()
{
	var i;

	var el = document.form1.gp_level;
	if (el.selectedIndex > 0)
	{
		var sel = el.options[el.selectedIndex].value;

		for(i in arGroupPolicy[sel])
		{
			if (arGroupPolicy[sel].hasOwnProperty(i))
			{
				var el1 = eval("document.form1.gp_" + i + "_parent");
				var el2 = eval("document.form1.gp_" + i + "");

				el1.checked = (sel == "parent");

				gpChangeParent(i);

				if(el2.type.toLowerCase() == 'checkbox')
				{
					el2.checked = arGroupPolicy[sel][i]['value'];
				}
				else
				{
					el2.value = arGroupPolicy[sel][i]['value'];
				}
			}
		}
	}
}

function gpChangeParent(key)
{
	var el1 = eval("document.form1.gp_" + key + "_parent");
	var el2 = eval("document.form1.gp_" + key + "");
	el2.disabled = el1.checked;
}

function gpSetLevel(level)
{
	var el = document.form1.gp_level;
	for (var i=0, len = el.options.length; i<len; i++)
		if(el.options[i].value == level)
			el.selectedIndex = i;
	return el.options[el.selectedIndex].value;
}

function gpSync()
{
	var level = {
		low: 0,
		middle: 0,
		high: 0,
		disabled: 0,
		total: 0
	};
	for(var key in arGroupPolicy['parent'])
	{
		if (arGroupPolicy['parent'].hasOwnProperty(key))
		{
			var el1 = eval("document.form1.gp_" + key + "_parent");
			var el2 = eval("document.form1.gp_" + key + "");

			level.total++;

			if(el1.checked)
			{
				level.disabled++;
			}
			else
			{
				switch(arGroupPolicy['parent'][key]['type'])
				{
					case 'BooleanRule':
						if(el2.checked)
						{
							if(arGroupPolicy['high'][key]['value'])
								level.high++;
							else if(arGroupPolicy['middle'][key]['value'])
								level.middle++;
							else
								level.low++;
						}
						else
						{
							if(!arGroupPolicy['high'][key]['value'])
								level.high++;
							else if(!arGroupPolicy['middle'][key]['value'])
								level.middle++;
							else
								level.low++;
						}
						break;

					case 'GreaterRule':
						if(parseInt(el2.value) >= parseInt(arGroupPolicy['high'][key]['value']))
							level.high++;
						else if(parseInt(el2.value) >= parseInt(arGroupPolicy['middle'][key]['value']))
							level.middle++;
						else
							level.low++;
						break;

					case 'IpMaskRule':
						if(el2.value >= arGroupPolicy['high'][key]['value'])
							level.high++;
						else if(el2.value >= arGroupPolicy['middle'][key]['value'])
							level.middle++;
						else
							level.low++;
						break;

					case 'LesserRule':
						if(parseInt(el2.value) <= parseInt(arGroupPolicy['high'][key]['value']))
							level.high++;
						else if(parseInt(el2.value) <= parseInt(arGroupPolicy['middle'][key]['value']))
							level.middle++;
						else
							level.low++;
						break;

					case 'LesserPositiveRule':
						if(parseInt(el2.value) > 0)
						{
							if(parseInt(el2.value) <= parseInt(arGroupPolicy['high'][key]['value']))
								level.high++;
							else if(parseInt(el2.value) <= parseInt(arGroupPolicy['middle'][key]['value']))
								level.middle++;
							else
								level.low++;
						}
						else
						{
							if(parseInt(arGroupPolicy['high'][key]['value']) <= 0)
								level.high++;
							else if(parseInt(arGroupPolicy['middle'][key]['value']) <= 0)
								level.middle++;
							else
								level.low++;
						}
						break;
				}
			}
		}
	}

	if(level.low > 0)
		gpSetLevel('low');
	else if(level.middle > 0)
		gpSetLevel('middle');
	else if(level.high > 0 && level.high == level.total)
		gpSetLevel('high');
	else if(level.disabled > 0 && level.disabled == level.total)
		gpSetLevel('parent');
	else
		gpSetLevel('');
}
