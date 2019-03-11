<?php

class Leads {

	// structure based on example data.
	private $id;
	private $email;
	private $firstName;
	private $lastName;
	private $address;
	private $entryDate;

	function __construct($id, $email, $firstName = null, $lastName = null, $address = null, $entryDate = null) {
	
		// set the id 
		$this->id = $id;
	
		// confirm email is valid if not leave blank.
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->email = $email;
		}
	
        /* 
		the other values are not required but we will set them in case they are passed in.
		I am using the setters so that the confirmation logic is not duplicated.
		*/
		$this->setFirstName($firstName);
		$this->setLastName($lastName);
		$this->setAddress($address);
		$this->setEntryDate($entryDate);
		
    }
	
	
	// getters
	
	public function getId (){
		return $this->id;
	}
	
	public function getEmail(){
		return $this->email;
	}
	
	public function getFirstName(){
		return $this->firstName;
	}
	
	public function getLastName(){
		return $this->lastName();
	}
	
	public function getAddress(){
		return $this->address;
	}
	
	public function getEntryDate(){
		// while in the Obj the date is stored as a unix timestamp this sets it back ATOM standard for readabuility.
		return date('Y-m-d\TH:i:sP',$this->entryDate);
	}
	
	public function getRawEntryDate(){
		// return the raw Unix timestamp
		return $this->entryDate;
	}
	
	public function getKeys(){
		return $this->id."_".$this->email;
	}
	
	
	// setters
	
	// since Id and Email are keys they should not change and do not get setters.
	public function setFirstName($firstName){
		if(is_string($firstName) ){
			$this->firstName = $firstName;
		}
	}
	
	public function setLastName($lastName){
		if(is_string($lastName)){
			$this->lastName = $lastName;
		}
	}
	
	public function setAddress($address){
		if(is_string($address)){
			$this->address = $address;
		}
	}
	
	public function setEntryDate($entryDate){
		
		// confirm an actiual date.
		if($tm = strtotime($entryDate)){
			$this->entryDate = $tm;
		}else{
			return false;
		}
	}
	
	/*
	right now only the date setter has confirmation code since no limitations or requirements (length, character limitations) have been specified for the other fields.
	*/

}