<?php

namespace ms07\SubversionBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Company{
	/**
	 * @MongoDB\Id(strategy="auto")
	 */
	protected $id;

	/**
	 * @var string
	 *
	 * @MongoDB\Field(type="string")
	 */
	protected $name;

	/**
	 * @var string
	 *
	 * @MongoDB\Field(type="string")
	 */
	protected $slug;

	/**
	 * @var int
	 *
	 * @MongoDB\Field(type="int")
	 */
	protected $allowed_revisions;

	/**
	 * @var ArrayCollection
	 *
	 * @MongoDB\ReferenceMany(targetDocument="User")
	 */
	protected $userList;

	/**
	 * @var ArrayCollection
	 *
	 * @MongoDB\ReferenceMany(targetDocument="Repository", mappedBy="company")
	 */
	protected $repositoryList;

	public function __construct(){
		$this->allowed_revisions = 1000;
		$this->userList = new ArrayCollection();
		$this->repositoryList = new ArrayCollection();
	}

	/**
	 * @return mixed
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @param mixed $allowed_revisions
	 */
	public function setAllowedRevisions($allowed_revisions){
		$this->allowed_revisions = $allowed_revisions;
	}

	/**
	 * @return mixed
	 */
	public function getAllowedRevisions(){
		return $this->allowed_revisions;
	}

	/**
	 * @param mixed $name
	 */
	public function setName($name){
		$this->name = $name;
	}

	/**
	 * @return mixed
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * @param mixed $slug
	 */
	public function setSlug($slug){
		$this->slug = $slug;
	}

	/**
	 * @return mixed
	 */
	public function getSlug(){
		return $this->slug;
	}

	/**
	 * @param mixed $userList
	 */
	public function setUserList($userList){
		$this->userList = $userList;
	}

	/**
	 * @return mixed
	 */
	public function getUserList(){
		return $this->userList;
	}


}
