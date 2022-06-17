<?php
namespace Bitrix\Tasks\Rest\Controllers;

use Bitrix\Main\Engine\CurrentUser;
use Bitrix\Main\UI\PageNavigation;
use Bitrix\Tasks\Access\ActionDictionary;
use Bitrix\Tasks\Access\TemplateAccessController;
use Bitrix\Main\Engine\Response;
use Bitrix\Tasks\Item\Task\Template as TaskTemplate;

class Template extends Base
{
	/**
	 * Return all DB and UF_ fields of task template
	 *
	 * @return array
	 */
	public function fieldsAction()
	{
		return \CTaskTemplates::getFieldsInfo();
	}

	/**
	 * Create new task template
	 *
	 * @param array $fields See in tasks.api.task.fields
	 * @param array $params
	 *
	 * @return bool|int
	 */
	public function addAction(array $fields, array $params = [])
	{
		$currentUserId = CurrentUser::get()->getId();

		if (!TemplateAccessController::can($currentUserId, ActionDictionary::ACTION_TEMPLATE_CREATE))
		{
			return false;
		}

		$fields = $this->filterFields($fields);

		return (new \CTaskTemplates())->Add($fields, $params);
	}

	/**
	 * Update existing task
	 *
	 * @param int $templateId
	 * @param array $fields See in tasks.api.task.fields
	 * @param array $params
	 *
	 * @return bool
	 */
	public function updateAction(int $templateId, array $fields, array $params = []): bool
	{
		$currentUserId = CurrentUser::get()->getId();

		if (!TemplateAccessController::can($currentUserId, ActionDictionary::ACTION_TEMPLATE_EDIT, $templateId))
		{
			return false;
		}

		$fields = $this->filterFields($fields);

		return (new \CTaskTemplates())->Update($templateId, $fields, $params);
	}

	/**
	 * Remove existing task
	 *
	 * @param int $templateId
	 * @param array $params
	 *
	 * @return bool
	 */
	public function deleteAction(int $templateId, array $params = []): bool
	{
		$currentUserId = CurrentUser::get()->getId();

		if (!TemplateAccessController::can($currentUserId, ActionDictionary::ACTION_TEMPLATE_EDIT, $templateId))
		{
			return false;
		}

		return \CTaskTemplates::Delete($templateId, $params);
	}

	/**
	 * Get list all task
	 *
	 * @param array $params
	 * @param PageNavigation $pageNavigation
	 *
	 * @return Response\DataType\Page
	 * @throws \Bitrix\Main\NotImplementedException
	 * @throws \Bitrix\Main\SystemException
	 */
	public function listAction(array $params = array(), PageNavigation $pageNavigation)
	{
		$params['limit'] = $pageNavigation->getLimit();
		$params['offset'] = $pageNavigation->getOffset();

		$result = TaskTemplate::find($params);
		$select = isset($params['select']) ? $params['select'] : null;

		$list = [];
		foreach ($result as $item)
		{
			$list[$item->id] = $item->getData($select);
		}

		return new Response\DataType\Page(
			$list, function () use ($params) {
			return TaskTemplate::getCount((array)$params['filter']);
		}
		);
	}

	/**
	 * Get task item data
	 *
	 * @param int $templateId
	 * @param array $params
	 *
	 * @return bool|\CDBResult|\CTaskTemplates
	 */
	public function getAction($templateId, array $params = array())
	{
		$template = new \CTaskTemplates();
		$template = $template->GetByID($templateId, $params);


		return $template;
	}
}