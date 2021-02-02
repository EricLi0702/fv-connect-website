# locg-filevine-api
This is a custom Filevine API script designed to log and filter subscription-based webhook actions configured in the Filevine API V2 portal.

api.php ---> Endpoint URL to handle the POST request from Filevine API configured in the V2 dev portal
connection.php ---> Establishes the database credentials for logging POST requests
ajaxfile.php ---> Handles the functionality of the table that logs the requests
index.html ---> Front end table that allows for filtering and searching through requests processed
index.js ---> Handles the front-end Javascript for the data table
style.css ---> Handles the front-end design of the data table
