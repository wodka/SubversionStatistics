<?php

namespace ms07\SubversionBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class Repository{
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
	 * @var Company
	 *
	 * @MongoDB\ReferenceOne(targetDocument="Company", inversedBy="repositoryList")
	 */
	protected $company;

	/**
	 * @var string
	 *
	 * @MongoDB\Field(type="string")
	 */
	protected $base_path;

	/**
	 * @var string
	 *
	 * @MongoDB\Field(type="string")
	 */
	protected $user;

	/**
	 * @var string
	 *
	 * @MongoDB\Field(type="string")
	 */
	protected $password;

	/**
	 * @var bool
	 *
	 * @MongoDB\Field(type="boolean")
	 */
	protected $validated;

	/**
	 * @var ArrayCollection
	 *
	 * @MongoDB\ReferenceMany(targetDocument="Revision", mappedBy="repository")
	 */
	protected $revisionList;

	/**
	 * @var ArrayCollection
	 *
	 * @MongoDB\ReferenceMany(targetDocument="Author", mappedBy="repository")
	 */
	protected $authorList;

	/**
	 * @var Revision
	 *
	 * @MongoDB\ReferenceOne(
	 *      targetDocument="Revision",
	 *      mappedBy="repository",
	 *      sort={"number"="desc"}
	 * )
	 */
	protected $lastRevision;

	public function __construct(){
		$this->revisionList = new ArrayCollection();
		$this->authorList = new ArrayCollection();
	}

	/**
	 * @return mixed
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * @param string $base_path
	 */
	public function setBasePath($base_path){
		$this->base_path = $base_path;
	}

	/**
	 * @return string
	 */
	public function getBasePath(){
		return $this->base_path;
	}

	/**
	 * @param \ms07\SubversionBundle\Document\Company $company
	 */
	public function setCompany($company){
		$this->company = $company;
	}

	/**
	 * @return \ms07\SubversionBundle\Document\Company
	 */
	public function getCompany(){
		return $this->company;
	}

	/**
	 * @param string $password
	 */
	public function setPassword($password){
		$this->password = $password;
	}

	/**
	 * @return string
	 */
	public function getPassword(){
		return $this->password;
	}

	/**
	 * @param string $user
	 */
	public function setUser($user){
		$this->user = $user;
	}

	/**
	 * @return string
	 */
	public function getUser(){
		return $this->user;
	}

	/**
	 * @param boolean $validated
	 */
	public function setValidated($validated){
		$this->validated = $validated;
	}

	/**
	 * @return boolean
	 */
	public function getValidated(){
		return $this->validated;
	}

	/**
	 * @param string $name
	 */
	public function setName($name){
		$this->name = $name;
	}

	/**
	 * @return string
	 */
	public function getName(){
		return $this->name;
	}

	/**
	 * @param Revision $lastRevision
	 */
	public function setLastRevision($lastRevision){
		$this->lastRevision = $lastRevision;
	}

	/**
	 * @return Revision
	 */
	public function getLastRevision(){
		return $this->lastRevision;
	}

	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection $revisionList
	 */
	public function setRevisionList($revisionList){
		$this->revisionList = $revisionList;
	}

	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getRevisionList(){
		return $this->revisionList;
	}

	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection $authorList
	 */
	public function setAuthorList($authorList){
		$this->authorList = $authorList;
	}

	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getAuthorList(){
		return $this->authorList;
	}
}
