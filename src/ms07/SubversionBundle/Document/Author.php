<?php

namespace ms07\SubversionBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Author{
	/**
	 * @MongoDB\Id(strategy="auto")
	 */
	protected $id;

	/**
	 * @var string
	 *
	 * @MongoDB\Field(type="string")
	 */
	protected $internal;

	/**
	 * @var Repository
	 *
	 * @MongoDB\ReferenceOne(targetDocument="Repository", inversedBy="revisionList")
	 */
	protected $repository;

	/**
	 * @return mixed
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @param mixed $internal
	 */
	public function setInternal($internal){
		$this->internal = $internal;
	}

	/**
	 * @return mixed
	 */
	public function getInternal(){
		return $this->internal;
	}

	/**
	 * @param \ms07\SubversionBundle\Document\Repository $repository
	 */
	public function setRepository($repository){
		$this->repository = $repository;
	}

	/**
	 * @return \ms07\SubversionBundle\Document\Repository
	 */
	public function getRepository(){
		return $this->repository;
	}
}
