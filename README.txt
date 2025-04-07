READ ME


installation guide
	install AMPPS
	Apache server up and running
	update PHP 7.4 or newer
	MySQL
	
Folder setup Website
	Photos folder has the photos in it
	
	Main html in this case include.html
	add Google library to include.html from commutes.html
		---- commutes.html from the library has some problems with posting to MySQL you have to do it twice for it to submit
		
	PHP
		IPAPI.php collects data when the user loads the page
		index.php loads in the homepage and connects the IPAPI and chatbot APIs
		chat.php is the user side of the chatbot
		chatbot.php is the generative AI part of the chatbot
		contact.php saves the confirmation info at the bottom of the page
		saveloc.php saves the location that the user enters.
		confirmation.php is only here to show that the location address has loaded that is all.
	CSS
		style.css is the CSS for the include.html page
Database stuff folder
		contact.sql
		apitest.sql
		chat_history
		user_commutes- there is a problem here I believe its in the library JavaScript it will only add the location if you do it twice
		

API Keys needed
	AJAX used in the contacts section to reload that div with the thank you message
	Google Routes
	Maps JavaScript key
	chatgpt key

Libraries used
	Google maps library 
	jQuery

chatbot OpenAI gpt-3.5 turbo
My AI works by taking in a message from the user something as simple as hello or what colors match but if it is to complex of a question
it will still answer it but some of the data will not make it into the database this is all done by using PHP and JavaScript.
The script sends the user's message to the OpenAI API using a cURL request. The request specifies the gpt-3.5-turbo model 
and includes the user's message in the payload. The script then processes the response from OpenAI and returns it then
the PHP is used to store that data into the database. 
	




 