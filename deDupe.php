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
global $changelog;


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
	if(in_array($entry, array('.', '..', 'original', 'finished'))){
		continue; 
	}
	
	echo "\nReading: $entry\n";
	
	
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
	// echo(print_r($json, true));
	
	/*
	I will assume that each json file has more than one entry and that the files are all formatted the same as the example. If this were to change in the future, more checks would need to be added here.
	*/
	$list = $json->leads;
	echo(count($list)." items found in file... processing...\n");
	
	// see README for thoughts on this logic.
	$newList = deDupe($list);
	
	
	// create new json file for the deduped list.
	$newFile = fopen($_SERVER['DOCUMENT_ROOT'] . "json/finished/".$entry, 'a+');
	
	fwrite($newFile, json_encode($newList));
	
	fclose($newFile);
	
	// alternately, we could export the data to the command line...
	// echo(print_r($newFile, true));
	
	// move the compleated file to the "original" directory.
	rename('json/'.$entry, 'json/original/'.$entry);
	
	
		
}

echo("\n".count($changelog)." changes made on this batch of files. Logging changes...\n");

// if you want a changeloge for each file it should go inside the while, if not this will consolidate the logs.
saveChangeLogToFile(); 

echo("...changes logged. Process finished.\n");


function deDupe($list){
	$emails = array();
	$ids = array();
	$masterList = array();
	global $changelog; // this will keep the same changelog for all files and iterations.
	
	foreach($list as $item ){
		$lead = new Leads($item->_id, $item->email, $item->firstName, $item->lastName, $item->address, $item->entryDate);
		
		
		if(!array_key_exists($lead->getId(), $ids) && !array_key_exists($lead->getEmail(), $emails)){
			// This lead has no matching ids or emails. It's an easy one.
			$emails[$lead->getEmail()] = count($masterList);
			$ids[$lead->getId()] = count($masterList);
			$masterList[] = $lead;
		}else{
			// see README for thoughts on this logic.
			if(array_key_exists($lead->getId(), $ids)){
				$changing = $ids[$lead->getId()];
				
				$new = compaireDates($masterList[$changing], $lead);
	
				/*
				At this step in the process one is expected to already be in the masterlist.
				Therefore if one is the newer item (by date), it will not change. It will overwrite the new item, rather than be overwritten.
				
				see README for thoughts on this logic.
				*/
				if($lead == $new){
					$changelog[] = new ChangeLog($lead->getKeys($lead), 'id', $masterList[$changing], $lead);
					
					$masterList[$changing] = $new;
					
				}
				
			}
			
			if(array_key_exists($lead->getEmail(), $emails)){
				$changing = $emails[$lead->getEmail()];
				
				$new = compaireDates($masterList[$changing], $lead);
	
				if($lead == $new){
					$changelog[] = new ChangeLog($lead->getKeys($lead), 'email', $masterList[$changing], $lead);
					
					$masterList[$changing] = $new;
					
				}
			}
			
			/*
			Because a duplicate could have changed the id or email we need to rebuild the lists.
			*/
			$emails = array();
			$ids = array();
			foreach($masterList as $key => $item){
				$emails[$item->getEmail()] = $key;
				$ids[$item->getId()] = $key;
			}
			
		}
		
	}
	
	return $masterList;
}

 
function compaireDates($one, $two){
	// two is considered the item later in the list.
	
	if($one->getRawEntryDate() > $two->getRawEntryDate()){
		// if the first is newer...
		$new = $one;
	}else{
		// if the second is newer or they are the same...
		$new = $two;
	}
	
	return $new;
}

function saveChangeLogToFile(){
	global $changelog;
	
	if(false === ($handle = opendir('changeLogs'))){
		// if there is no changeLogs folder do not save the logs in a diferent place.
		return false;
	}
	
	// name the new file with the date.
	$fName = 'log-'.date('Y-m-d-His').'.json'; 
	
	$handle = fopen($_SERVER['DOCUMENT_ROOT'] . "changeLogs/".$fName, 'a+');
	
	fwrite($handle, json_encode($changelog));
	
	fclose($handle);
}




