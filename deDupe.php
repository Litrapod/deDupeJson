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


//in order to declutter the process the lead object will be in a seperate file.
include 'Leads.php';