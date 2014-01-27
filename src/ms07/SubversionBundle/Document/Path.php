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
	 * @MongoDB\ReferenceOne(targetDocument="Revision", inversedBy="pathList")
	 */
	protected $revision;

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
	protected $stat_insertion;

	/**
	 * @var int
	 *
	 * @MongoDB\Field(type="int")
	 */
	protected $stat_deletion;

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
	 * @param int $stat_deletion
	 */
	public function setStatDeletion($stat_deletion){
		$this->stat_deletion = $stat_deletion;
	}

	/**
	 * @return int
	 */
	public function getStatDeletion(){
		return $this->stat_deletion;
	}

	/**
	 * @param int $stat_insertion
	 */
	public function setStatInsertion($stat_insertion){
		$this->stat_insertion = $stat_insertion;
	}

	/**
	 * @return int
	 */
	public function getStatInsertion(){
		return $this->stat_insertion;
	}
}
