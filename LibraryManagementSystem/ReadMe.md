Read Me
Requirements:
Mamp(3.3.1) App to create server to host the Application.
MySql Database is supported in Mamp.
How to Run?
Place all html, js and php files in htdocs folder of MAMP.
Start the server using MAMP application.
Execute the SQL file to create schema, tables.
Now you will be able open any portal through HTML files
and start using application. 


Design Document
Database Design:
Schema and Tables under it created on MySQL database following
normalization rules, SQL File containing DDL and DML is attached.
Front-End Design:
• User Interface is built using html and JavaScript.
• Results will be displayed as Table when user searches for any books
using ISBN, Author, Title.
• Most of the Client interface is responsive made through JavaScript.
Backend Design:
• This Application was built using PHP, Any SQL commands required to run
are executed on the database from using PHP by making an AJAX call from
JavaScript files.
• Upon receiving results from database from query they are sent back to
client using echo in PHP.
Design Assumptions while implementing the Application:
• Multiple copies of books are available assuming that ISBN for all the books
are different.
• ISBN10 is used for the unique identification of books.
• User can search for any book using ISBN, Title, Author.
• User can Check-out multiple books at once (not more than three) from list
of books shown upon search.
• User can check-out books even if he has pending fines and not exceeded
max book limit.
• To Check-in books user can go to check in page and select the books to
check in using card_id, book_id or borrower name.
• Users will be able to do multiple books check in at the same time, Also if
there are any users are free to pay during check in or later through
payment portal.
• As said in the requirements doc, New User Registration Portal will be able
server new user signups.
• New users are checked whether already registered or not using SSN.
• Borrowers will be able to pay fines while checking in or later through
payments portal.
• Fine payments portal can be use to update fines or calculate fines for any
given card_id and also can make payments through the portal.
• In the Fine Payments portal users should update and calculate before paying fines
