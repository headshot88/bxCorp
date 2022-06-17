<?php
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage tasks
 * @copyright 2001-2021 Bitrix
 */

namespace Bitrix\Tasks\Access\Rule;

use Bitrix\Main\Loader;
use Bitrix\Tasks\Access\ActionDictionary;
use Bitrix\Tasks\Access\Model\TemplateModel;
use Bitrix\Tasks\Access\Permission\PermissionDictionary;
use Bitrix\Main\Access\AccessibleItem;
use Bitrix\Tasks\Access\Role\RoleDictionary;
use Bitrix\Tasks\Access\Rule\Traits\ChecklistTrait;

class ChecklistEditRule extends \Bitrix\Main\Access\Rule\AbstractRule
{
	use ChecklistTrait;

	public function execute(AccessibleItem $task = null, $params = null): bool
	{
		if (!$task)
		{
			return false;
		}

		if ($this->user->isAdmin())
		{
			return true;
		}

		if ($task instanceOf TemplateModel)
		{
			return $this->controller->check(ActionDictionary::ACTION_TEMPLATE_EDIT, $task, $params);
		}

		if (
			$task->isMember($this->user->getUserId(), RoleDictionary::ROLE_DIRECTOR)
			|| array_intersect($task->getMembers(RoleDictionary::ROLE_DIRECTOR), $this->user->getAllSubordinates())
		)
		{
			return true;
		}

		$checklist = $this->getModelFromParams($params);
		if (
			$checklist->getEntityId() > 0
			&& $checklist->getEntityId() !== $task->getId()
		)
		{
			return false;
		}

		if ($checklist->getOwnerId() === $this->user->getUserId())
		{
			return true;
		}

		if (in_array($checklist->getOwnerId(), $this->user->getAllSubordinates()))
		{
			return true;
		}

		if (
			(
				$task->isMember($this->user->getUserId(), RoleDictionary::ROLE_RESPONSIBLE)
				|| $task->isMember($this->user->getUserId(), RoleDictionary::ROLE_ACCOMPLICE)
			)
			&& $this->user->getPermission(PermissionDictionary::TASK_RESPONSE_CHECKLIST_EDIT)
		)
		{
			return true;
		}

		if (
			$task->getGroupId()
			&& Loader::includeModule("socialnetwork")
			&& \CSocNetFeaturesPerms::CanPerformOperation($this->user->getUserId(), SONET_ENTITY_GROUP, $task->getGroupId(), "tasks", "edit_tasks")
		)
		{
			return true;
		}

		return false;
	}
}