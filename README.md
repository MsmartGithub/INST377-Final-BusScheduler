#Guide

#Database
 - busDB
	- users
	- stops
	- routes
	- buildings
	dbInfo.php is the masterfile for the database creation. It will create a MySQL database
	using NextBus API and UMD.io Building Data. The NextBus API is used in nextbusapi.php
	to populate the stops and routes tables. The UMD.io API is used to populate the buildings table.
	The users table is created but left empty, users will register into this table.

#Website

	The website launches to the index page which prompts the user to register or log in. Registering
	a user adds their information into the database. Upon performing a sucessful log in, the user is brought
	to the home.php page which displays their schedule if they have one, and displays a text input box for a
	user to input a new schedule.

#setup
	Export all files from the SQL and Code folders to the same location. Run the dbInfo.php file to set up the database.
	Then the website can launch from index.php. 