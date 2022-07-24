{"version":3,"sources":["script.js"],"names":["BX","namespace","Crm","Report","ColumnFunnel","options","this","columnFunnelWrapperContainer","context","querySelector","scaleBoxContainer","infoPopupContentTemplate","firstColumnsContainer","secondColumnsContainer","thirdColumnsContainer","columnsValues","maxColumnValue","minColumnValue","informationPopup","data","columns","init","prototype","i","length","entity","undefined","j","column","columnNode","buildColumn","appendChild","node","bind","handleColumnMouseOver","handleColumnMouseOut","push","valueNode","addEventListener","openSlider","renderScaleItems","setTimeout","adjustColumnsHeight","url","SidePanel","Instance","open","cacheable","maxValue","getColumnMaxValue","minValue","getColumnMinValue","scaleItemValues","scaleItemSeparator","scaleItemCount","Math","round","value","classList","add","reverse","forEach","create","html","attrs","className","props","style","backgroundColor","color","link","currentColumnNode","currentColumnValue","calculatedPercentValue","calculatePercentValue","height","currentValue","percentValue","columnObject","openInformationPopup","close","destroy","PopupWindow","bindOptions","position","offsetLeft","offsetTop","noAllPaddings","autoHide","draggable","restrict","content","getInformationPopupContent","show","infoPopupContentTemplateLabel","infoPopupContentTemplateTopCard","infoPopupContentTemplateTopTitle","infoPopupContentTemplateTopValue","infoPopupContentTemplateSecondCard","infoPopupContentTemplateSecondTitle","infoPopupContentTemplateSecondValue","infoPopupContentTemplateThirdCard","infoPopupContentTemplateThirdTitle","infoPopupContentTemplateThirdValue","infoPopupContentTemplateForthCard","infoPopupContentTemplateForthTitle","infoPopupContentTemplateForthValue","borderColor","innerText","title","firstAdditionalTitle","display","innerHTML","firstAdditionalValue","firstAdditionalUnit","secondAdditionalTitle","secondAdditionalValue","secondAdditionalUnit","thirdAdditionalValue","thirdAdditionalTitle","thirdAdditionalUnit","forthAdditionalValue","forthAdditionalTitle","forthAdditionalUnit","getColumnValues","max","apply","min"],"mappings":"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","file":"script.map.js"}