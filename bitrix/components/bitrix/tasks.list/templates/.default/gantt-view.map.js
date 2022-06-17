{"version":3,"sources":["gantt-view.js"],"names":["tasksListNS","approveTask","taskId","ganttChart","updateTask","status","dateCompleted","Date","SetServerStatus","bGannt","disapproveTask","SetServerCloseStatus","params","columnsIds","data","mode","sessid","BX","message","path_to_task","id","getColumnsOrder","i","ajax","method","dataType","url","tasksListAjaxUrl","processData","onsuccess","reply","UI","Notification","Center","notify","content","taskInfo","parseJSON","tasksRenderJSON","quickInfoData","menuItems","realStatus","tasksMenuPopup","getTaskById","setMenuItems","__FilterMenuByStatus","ganttTask","TasksTimerManager","reLoadInitTimerDataFromServer","window","TasksIFrameInst","onTaskChanged","html","__InvalidateMenus","CloseTask","StartTask","AcceptTask","PauseTask","RenewTask","DeferTask","AddToFavorite","parameters","add","datum","DeleteFavorite","rowDelete","TASKS_table_view_onDeleteClick_onSuccess","DeleteTask","toString","trim","length","removeTask","onCustomEvent","onPopupTaskChanged","task","__RenewMenuItems","parentTaskId","parentTask","hasChildren","expand","projectId","getProjectById","project","addProjectFromJSON","name","projectName","opened","canCreateTasks","projectCanCreateTasks","canEditTasks","projectCanEditTasks","onPopupTaskAdded","addTaskFromJSON","onPopupTaskDeleted","lastScroll","onBeforeShow","browser","IsOpera","layout","timeline","scrollLeft","onAfterShow","onBeforeHide","onAfterHide","clone"],"mappings":"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","file":"gantt-view.map.js"}