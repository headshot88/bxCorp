<?php

namespace Bitrix\Crm\ListEntity\Entity;

use Bitrix\Crm\ListEntity\Entity;

class Quote extends Entity
{
	public function getTypeName(): string
	{
		return \CCrmOwnerType::QuoteName;
	}
}
