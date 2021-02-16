# Gammu-smsd php-Gateway
Simple, "One Php File" Frontend for Gammu-smsd



## Installation:
- Copy the index.php to the web server.

- Edit the variables for database connection.

- Edit the variables for authentication.



## Features:
#### - Sent Box

Displays list of sent SMS. From the database "sentitems" table.

#### - In Box

Displays list of sent SMS. From the database "inbox" table.

#### - Conversations

Query join of the database "inbox" and "senditens" tables to display list of available conversations.

#### - Out Box

Displays list of OutBox (Queued For Delivery) SMS. From the database "outbox" table.

#### - Send SMS

Form for sending SMS.

#### - SMS Send API

Send sms from command line. Example: http://localhost/?do=api&token=your_token&phone=to_phone&message=your_message

#### - Log

Displays the smsd log file.

