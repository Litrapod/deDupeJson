Project Info:

To run this project you will need to have php installed. 
The program can be triggered from the command line with the code: php -f deDupe.php
it will go through all the json files in the json folder. 
It will compaire items in the files but will not compare the files to each other. it also assumes that the files are all structured basically the same as the example, that is, no extra values, and no sub-arrays. 
It will alert if a non-json file is in the json folder and skip it. 


Project Structure:

deDupe.php
Leads.php
ChangeLog.php
json
- leads[1][1][1].json
	
	
deDupe.php -- this file is the main program that processes the duplicates.
Leads.php -- this file is the leads object
ChangeLog.php -- this is the object for the log.


Thoughts:

[deDupe ln 73]
Right now I have the program checking for duplicates by Id and email seperatly, one problem that could arrise from this is if an item later in the list (a) has both an Id that matches (b), and an email that matches (c), but the matching items are diferent. The question in this case becomes are (c) and (b) matches? Until (a) came along they were not, and they might have compleatly diferent information prior to (a) but after the deDupe logic runs, they will match.
One solution to this is to run the dedupe process over the list until all possible duplicates are eliminated. The downside is this might remove desired data. This is a logic question that I would generally ask a project lead. It depends on how important the data is.


