<?php

namespace ms07\SubversionBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Revision{
	/**
	 * @MongoDB\Id(strategy="auto")
	 */
	protected $id;

	/**
	 * @var int
	 *
	 * @MongoDB\Field(type="int")
	 */
	protected $number;

	/**
	 * @var Author
	 *
	 * @MongoDB\ReferenceOne(targetDocument="Author")
	 */
	protected $author;

	/**
	 * @var \DateTime
	 *
	 * @MongoDB\Field(type="date")
	 */
	protected $created;

	/**
	 * @var ArrayCollection
	 *
	 * @MongoDB\ReferenceMany(targetDocument="Path", mappedBy="revision")
	 */
	protected $pathList;

	/**
	 * @var Repository
	 *
	 * @MongoDB\ReferenceOne(targetDocument="Repository", inversedBy="revisionList")
	 */
	private $repository;

	public function __construct(){
		$this->pathList = new ArrayCollection();
	}

	/**
	 * @return mixed
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @param \ms07\SubversionBundle\Document\Author $author
	 */
	public function setAuthor($author){
		$this->author = $author;
	}

	/**
	 * @return \ms07\SubversionBundle\Document\Author
	 */
	public function getAuthor(){
		return $this->author;
	}

	/**
	 * @param \DateTime $created
	 */
	public function setCreated($created){
		$this->created = $created;
	}

	/**
	 * @return \DateTime
	 */
	public function getCreated(){
		return $this->created;
	}

	/**
	 * @param int $number
	 */
	public function setNumber($number){
		$this->number = $number;
	}

	/**
	 * @return int
	 */
	public function getNumber(){
		return $this->number;
	}

	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection $pathList
	 */
	public function setPathList($pathList){
		$this->pathList = $pathList;
	}

	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getPathList(){
		return $this->pathList;
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
