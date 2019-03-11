<?php 

/*
This project was created on 3/10/19 by Kalinda Little
The goal is to inport json files, assess the contents and export the data after removing the duplicate entries.

* An entry is a duplicate if the id or email match. 
* The json must have both an ID and a Email field to be considered valid.
* If there are duplicates the newest data should be maintained.
* If the dates are the same the later entry should be maintained.
* the program should log all changes.

*/


//in order to declutter the process the objects will be in seperate files.
include 'Leads.php';
include 'ChangeLog.php';


if(!file_exists('json') || false == ($handle = opendir('json')) ){
	// if the json folder does not exist report error and exit.
	echo('The Json folder must exist in this directory for this program to run.');
	die();
}

/* 
	Go through each file in the json directory for changes.
	At this point each file will be evaluated individually IE, the files will not compair to other files.
*/
while (false !== ($entry = readdir($handle))) {
	
	// skip file structure entries.
	if($entry == '.' || $entry == '..'){
		continue; 
	}
	
	echo "Reading $entry\n";
	
	
	// check the file...
	if( false == ($fileContents = file_get_contents('json/'.$entry))){
		echo("$entry is not a proper file, moving on. \n");
		continue;
	}
	
	if(false == ($json = json_decode($fileContents))){
		echo("$entry is not a json file or can not be decoded. Please confirm the file format.\n");
		continue;
	}
	// this will list the raw json of the file.
	//echo(print_r($json));
	
	/*
	I will assume that each json file has more than one entry adn that the files are all formatted the same as the example. If this were to change in the future, more checks would need to be added here.
	*/
	$list = $json->leads;
	
	$newList = array();
	
	foreach($list as $item ){
		$lead = new Leads($item->_id, $item->email, $item->firstName, $item->lastName, $item->address, $item->entryDate);
		
		$newList[$lead->getKeys()] = $lead;
	}
	
	echo(count($newList));
		
}



