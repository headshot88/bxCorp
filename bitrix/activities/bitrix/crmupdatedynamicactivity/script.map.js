{"version":3,"sources":["script.js"],"names":["exports","main_core","main_popup","namespace","Reflection","CrmUpdateDynamicActivity","options","_this","this","babelHelpers","classCallCheck","Type","isPlainObject","documentType","isRobot","form","document","forms","formName","isNil","entityTypeIdSelect","dynamic_type_id","currentEntityTypeId","value","entityTypeDependentElements","querySelectorAll","fieldsListSelect","querySelector","addConditionButton","entitiesFieldsContainers","conditinIdPrefix","fieldsMap","Map","Object","entries","filterFieldsContainer","filteringFieldsPrefix","filterFieldsMap","documentName","BX","Bizproc","Automation","API","ConditionGroup","conditionGroup","conditions","currentValues","Array","from","keys","forEach","entityTypeId","set","isObject","render","createClass","key","init","Event","bind","onEntityTypeIdChange","onFieldsListSelectClick","onAddConditionButtonClick","Dom","clean","children","elem","remove","element","hide","show","renderFilterFields","renderEntityFields","selector","ConditionGroupSelector","fields","values","get","fieldPrefix","appendChild","createNode","_this2","fieldId","addCondition","event","preventDefault","activity","menuItems","map","_ref","_ref2","slicedToArray","field","text","Name","onclick","_","item","popupWindow","close","menuManagerOptions","id","Math","random","toString","bindElement","items","autoHide","offsetLeft","getPosition","width","angle","position","offset","zIndex","className","events","onPopupClose","destroy","MenuManager","defaultFieldId","addRobotCondition","addBizprocCondition","conditionId","titleNode","create","attrs","deleteButton","props","href","Loc","getMessage","click","deleteCondition","fieldNode","renderField","getElementById","newConditionRow","insertRow","substr","entityFieldSelect","getCurrentFieldsOptions","change","fieldValueNode","newFieldId","srcElement","replaceChild","equalSignNode","entityFieldValueNode","deleteConditionButton","node","insertCell","selectedFieldId","_ref3","_ref4","FieldName","selected","undefined","FieldType","renderControl","window","Main"],"mappings":"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","file":"script.map.js"}