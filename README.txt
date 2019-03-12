Project Info:

To run this project you will need to have php installed. 
first put any json files in the json folder. not one of the subfolders, thouse are for later.
The program can be triggered from the command line with the code: php -f deDupe.php
it will go through all the json files in the json folder. 
It will compaire items in the files but will not compare the files to each other. it also assumes that the files are all structured basically the same as the example, that is, no extra values, and no sub-arrays. 
It will alert if a non-json file is in the json folder and skip it. 
When finished it will put the original files in the "json/original" folder and create a new file with the same name in the "json/finished" file.
It will then save the changes to a new file in the ChangeLogs folder. 
All these files will be in json.
The changelog file will be comprised of changes for all files run in that batch.


Project Structure:

deDupe.php
Leads.php
ChangeLog.php
json
- finished
- original
- leads[1][1][1].json
changeLogs
- log-2019-03-12-022956.json
	
	
deDupe.php -- this file is the main program that processes the duplicates.
Leads.php -- this file is the leads object
ChangeLog.php -- this is the object for the log.
json/finished -- the folder for the finished json files.
json/original -- the folder to store the original files once they have been processed.
changeLogs -- the folder for the logged changes.


Thoughts:

[deDupe ln61, and ln106]
Right now I have the program checking for duplicates by Id and email seperatly, one problem that could arrise from this is if an item later in the list (a) has both an Id that matches (b), and an email that matches (c), but the matching items are diferent. The question in this case becomes are (c) and (b) matches? Until (a) came along they were not, and they might have compleatly diferent information prior to (a) but after the deDupe logic runs, they will match.
One solution to this is to run the dedupe process over the list until all possible duplicates are eliminated. The downside is this might remove desired data. This is a logic question that I would generally ask a project lead. It depends on how important the data is.


[deDupe ln116]
There are a few ways that the changes could be logged. I've chosen to do with the less verbose version code wise, but this solution will mean more objects in memory, or more rows in a database. Another solution would be to record each time each value was changed [which might be usefull if we were keeping track of end user actions]. 
