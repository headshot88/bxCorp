{"version":3,"sources":["script.js"],"names":["BX","namespace","Crm","Activity","CrmGenerateEntityDocumentActivity","init","params","this","documentType","entityType","entityTypeId","selectTemplateNodeId","selectMyCompanyNodeId","selectMyCompanyRequisiteNodeId","selectMyCompanyBankDetailNodeId","selectFieldNodeId","textFieldNodeId","deleteRowClassName","openFieldInfoUrlClassName","addNewFieldButtonNodeId","fieldTableRowClassName","fieldTableRowTagName","isRobot","requisitesMap","initEvents","bind","proxy","getTemplateFields","value","length","bindDelegate","document","className","event","preventDefault","remove","target","parentNode","SidePanel","Instance","open","getAttribute","width","cacheable","location","href","addNewField","myCompanyId","parseInt","requisites","myCompanyRequisites","adjustSelect","requisiteId","bankDetails","myCompanyBankDetails","selectNodeId","variants","selectNode","options","querySelector","variantId","hasOwnProperty","push","Dom","create","attrs","text","clean","forEach","node","appendChild","name","fieldRows","findChildrenByClassName","i","children","dataset","ajax","post","site_id","message","sessid","bitrix_sessid","document_type","activity","entity_type","content_type","customer_action","placeholder","templateId","response","fieldToInsert","newNode","html","insertAfter","getClass","dlg","Bizproc","Automation","Designer","getRobotSettingsDialog","template","initRobotSettingsControls","robot","runAction","data","id","then","cleanNode","templateFields","title","adjust","alert","errors","pop","window"],"mappings":"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","file":"script.map.js"}