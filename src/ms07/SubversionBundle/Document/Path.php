<?php

namespace ms07\SubversionBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Path{
	/**
	 * @MongoDB\Id(strategy="auto")
	 */
	protected $id;

	/**
	 * @var Revision
	 *
	 * @MongoDB\ReferenceOne(targetDocument="Revision", inversedBy="pathList", simple=true)
	 */
	protected $revision;

	/**
	 * @var Repository
	 *
	 * @MongoDB\ReferenceOne(targetDocument="Repository", simple=true)
	 */
	protected $repository;

	/**
	 * @var string
	 *
	 * @MongoDB\Field(type="string")
	 */
	protected $path;

	/**
	 * @var int
	 *
	 * @MongoDB\Field(type="int")
	 */
	protected $stat_insert;

	/**
	 * @var int
	 *
	 * @MongoDB\Field(type="int")
	 */
	protected $stat_delete;

	/**
	 * @var int
	 *
	 * @MongoDB\Field(type="int")
	 */
	protected $stat_change;

	/**
	 * @return mixed
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @param string $path
	 */
	public function setPath($path){
		$this->path = $path;
	}

	/**
	 * @return string
	 */
	public function getPath(){
		return $this->path;
	}

	/**
	 * @param \ms07\SubversionBundle\Document\Revision $revision
	 */
	public function setRevision($revision){
		$this->revision = $revision;
	}

	/**
	 * @return \ms07\SubversionBundle\Document\Revision
	 */
	public function getRevision(){
		return $this->revision;
	}

	/**
	 * @param int $stat_change
	 */
	public function setStatChange($stat_change){
		$this->stat_change = $stat_change;
	}

	/**
	 * @return int
	 */
	public function getStatChange(){
		return $this->stat_change;
	}

	/**
	 * @param int $stat_delete
	 */
	public function setStatDelete($stat_delete){
		$this->stat_delete = $stat_delete;
	}

	/**
	 * @return int
	 */
	public function getStatDelete(){
		return $this->stat_delete;
	}

	/**
	 * @param int $stat_insert
	 */
	public function setStatInsert($stat_insert){
		$this->stat_insert = $stat_insert;
	}

	/**
	 * @return int
	 */
	public function getStatInsert(){
		return $this->stat_insert;
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
