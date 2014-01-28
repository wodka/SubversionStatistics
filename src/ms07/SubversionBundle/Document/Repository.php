<?php

namespace ms07\SubversionBundle\Document;

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
}
