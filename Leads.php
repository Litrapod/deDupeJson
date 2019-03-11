<?php

class Leads {

	// structure based on example data.
	private $id;
	private $email;
	private $firstName;
	private $lastName;
	private $address;
	private $entryDate;

	function __construct($id, $email) {
	
		// confirm email is valid if not leave blank.
		if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
			$this->email = $email;
		}
	
        // set the id 
		$this->id = $id;
		
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
	
	// setters
	
	// since Id and Email are keys they should not change and do not get setters.
	public function setFirstName($firstName){
		$this->firstName = $firstName;
	}
	
	public function setLastName($lastName){
		$this->lastName = $lastName;
	}
	
	public function setAddress($address){
		$this->address = $address;
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
	right now only the date setter has confirmation code since no limitations or requirements (length, character limitations) have been spesified for the other fields.
	*/

}