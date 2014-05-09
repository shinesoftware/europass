<?php
namespace Europass\Model;

class Personaldata implements PersonaldataInterface
{
    protected $firstname;
    protected $lastname;
    protected $birthdate;
    protected $gender;
    
	/**
	 * @return the $firstname
	 */
	public function getFirstname() {
		return $this->firstname;
	}

	/**
	 * @return the $lastname
	 */
	public function getLastname() {
		return $this->lastname;
	}

	/**
	 * @param field_type $firstname
	 */
	public function setFirstname($firstname) {
		$this->firstname = $firstname;
	}

	/**
	 * @param field_type $lastname
	 */
	public function setLastname($lastname) {
		$this->lastname = $lastname;
	}
	
	/**
	 * @return the $birthdate
	 */
	public function getBirthdate() {
		return $this->birthdate;
	}
	
	/**
	 * @param field_type $birthdate
	 */
	public function setBirthdate($birthdate) {
		$this->birthdate = $birthdate;
	}
	
	/**
	 * @return the $gender
	 */
	public function getGender() {
		return $this->gender;
	}

	/**
	 * @param field_type $gender
	 */
	public function setGender($gender) {
		$this->gender = $gender;
	}

	

}