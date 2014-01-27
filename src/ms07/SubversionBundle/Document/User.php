<?php

namespace ms07\SubversionBundle\Document;

use Doctrine\Common\Collections\ArrayCollection;
use FOS\UserBundle\Document\User as BaseUser;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

/**
 * @MongoDB\Document
 */
class User extends BaseUser{
	/**
	 * @MongoDB\Id(strategy="auto")
	 */
	protected $id;

	/**
	 * @var ArrayCollection
	 *
	 * @MongoDB\ReferenceMany(targetDocument="Company")
	 */
	protected $companyList;

	public function __construct(){
		parent::__construct();
		// your own logic

		$this->companyList = new ArrayCollection();
	}

	/**
	 * @param \Doctrine\Common\Collections\ArrayCollection $companyList
	 */
	public function setCompanyList($companyList){
		$this->companyList = $companyList;
	}

	/**
	 * @return \Doctrine\Common\Collections\ArrayCollection
	 */
	public function getCompanyList(){
		return $this->companyList;
	}
}
