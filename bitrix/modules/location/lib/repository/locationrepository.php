<?php

namespace Bitrix\Location\Repository;

use Bitrix\Location\Common\Point;
use Bitrix\Location\Entity;
use Bitrix\Location\Repository\Location\Strategy\Delete;
use Bitrix\Location\Repository\Location\Strategy\Find;
use Bitrix\Location\Repository\Location\Strategy\Save;
use Bitrix\Main\Result;

/**
 * Class Location
 * @package Bitrix\Location\Repository
 */
class LocationRepository
{
	private $findStrategy;
	private $saveStrategy;
	private $deleteStrategy;

	/**
	 * LocationRepository constructor.
	 * @param Find $findStrategy
	 * @param Save $saveStrategy
	 * @param Delete $deleteStrategy
	 */
	public function __construct(Find $findStrategy, Save $saveStrategy, Delete $deleteStrategy)
	{
		$this->findStrategy = $findStrategy;
		$this->saveStrategy = $saveStrategy;
		$this->deleteStrategy = $deleteStrategy;
	}

	/**
	 * @inheritDoc
	 */
	public function findById(int $id, string $languageId, int $searchScope)
	{
		return $this->findStrategy->findById($id, $languageId, $searchScope);
	}

	/**
	 * @param string $externalId
	 * @param string $sourceCode
	 * @param string $languageId
	 * @param int $searchScope
	 * @return Entity\Location|bool|null
	 */
	public function findByExternalId(string $externalId, string $sourceCode, string $languageId, int $searchScope)
	{
		return $this->findStrategy->findByExternalId($externalId, $sourceCode, $languageId, $searchScope);
	}

	/**
	 * @param Point $point
	 * @param string $languageId
	 * @param int $searchScope
	 * @return Entity\Generic\Collection|bool
	 */
	public function findByPoint(Point $point, string $languageId, int $searchScope)
	{
		return $this->findStrategy->findByPoint($point, $languageId, $searchScope);
	}

	/**
	 * @param string $text
	 * @param string $languageId
	 * @param int $searchScope
	 * @return Entity\Generic\Collection|bool
	 */
	public function findByText(string $text, string $languageId, int $searchScope)
	{
		return $this->findStrategy->findByText($text, $languageId, $searchScope);
	}

	/**
	 * @param Entity\Location $location
	 * @return Result
	 */
	public function save(Entity\Location $location)
	{
		return $this->saveStrategy->save($location);
	}

	/**
	 * @param Entity\Location $location
	 * @return Result
	 */
	public function delete(Entity\Location $location): Result
	{
		return $this->deleteStrategy->delete($location);
	}

	/**
	 * @param Entity\Location $location
	 * @param string $languageId
	 * @param int $searchScope
	 * @return Entity\Location\Parents
	 */
	public function findParents(Entity\Location $location, string $languageId, int $searchScope)
	{
		return $this->findStrategy->findParents($location, $languageId, $searchScope);
	}

	/**
	 * @param Entity\Location\Parents $parents
	 * @return Result
	 */
	public function saveParents(Entity\Location\Parents $parents)
	{
		return $this->saveStrategy->saveParents($parents);
	}
}
