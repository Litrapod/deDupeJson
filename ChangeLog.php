<?php

class ChangeLog {

	private $key; // key should be the key combo of id and email from the Lead obj;
	private $fieldName;
	private $oldValue;
	private $newValue;
	private $changeDate;

	
	/* 
	Since there's no point having a log without all the fields, all of them are required for a new object. except the date, which is the time of creation.
	Also since there likely will be more than one change per Lead any DB table build off this object should have an auto increment ID as well as the key of the Lead.
	*/
	function __construct($key, $fieldName, $old, $new){
		$this->key = $key;
		$this->fieldName = $fieldName;
		$this->oldValue = $old;
		$this->newValue = $new;
		$this->changeDate = date('U'); //new unix timestamp
	}
	
	// no setters since you should not change a log.
	
	// getters
	
	public function getId(){
		return $this->id;
	}
	
	public function getFieldName(){
		return $this->fieldName;
	}
	
	public function getOldValue(){
		return $oldValue;
	}
	
	public function getNewValue(){
		return $newValue;
	}
	
	public function getChangeDate(){
		return date('Y-m-d\TH:i:sP',$this->changeDate);
	}
	
	public function getRawChangeDate(){
		return $this->changeDate;
	}


}