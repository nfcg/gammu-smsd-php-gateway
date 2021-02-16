<?php
//////////////////////////////// * Start Conf * ////////////////////////////////
$db      = 'smsd';
$user    = 'smsd';
$pass    = 'your_password'; // Please Change This
$charset = 'utf8mb4';

$username = 'admin';
$password = 'admin'; // Please Change This

$your_number = '+351000000000'; // Please Change This

$get_text = 'textutf8'; // text or textutf8

$log = '/var/log/smsd.log';
$max_log_lines = '20';

$api_tokens = array("f5AOByZPMMws65YqJVkaVfjRSK6GqSYD");

$sort = 'asc'; // asc or desc

$title = 'Gammu SMS Gateway'; 
$footer = 'Copyright © Gammu SMS Gateway'; 
//////////////////////////////// * End Conf * ////////////////////////////////



$do = $_GET['do'];

$do_array = array("inbox", "sent", "conversation", "view_conversation", "message", "send_message", "logout", "outbox", "api", "log", "del", null);
$exclude_html = array("send_message", "view_conversation", "del");

if (!in_array($do, $do_array)) { echo json_encode("Not Allowed"); exit(); }

if ($do == "api") {
$token = urldecode($_GET['token']);

if (in_array($token, $api_tokens)) {

$phone = nl2br($_GET['phone']); 
$phone = urlencode($phone);

$message = escapeshellarg($_GET['message']);

$send = shell_exec("gammu-smsd-inject TEXT $phone -unicode -$get_text $message").PHP_EOL;
echo json_encode($send); exit();

} else { echo json_encode("Not Allowed"); exit();}
exit();
}

session_start();
    
$hash = md5('cxN4QtJ46bepic0p3pmWyyqPc7re0eHj'.$pass.'NcaR3CfhVM3xORcP0et2p0wwEPGMbNG5'); 

function display_login_form(){
echo'
<h2><i class="text-primary fas fa-sign-in-alt"></i> Log In</h2>
<p class="text-secondary">Log In Form</p>
  <form action="" class="needs-validation" method="post" novalidate>
    <div class="form-group">
      <label class="text-primary" for="username"><i class="fas fa-user"></i> Username:</label>
      <input type="text" class="form-control" id="username" placeholder="Enter username" name="username" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please Fill Out Username.</div>
    </div>
    <div class="form-group">
      <label class="text-primary" for="password"><i class="fas fa-key"></i> Password:</label>
      <input type="password" class="form-control" id="password" placeholder="Enter password" name="password" required>
      <div class="valid-feedback">Valid.</div>
      <div class="invalid-feedback">Please Fill Out Password.</div>
    </div>
    <button type="submit" name="submit" value="submit" class="btn btn-primary">Submit</button>
  </form>
<script>
(function() {
  "use strict";
  window.addEventListener("load", function() {
    var forms = document.getElementsByClassName("needs-validation");
    var validation = Array.prototype.filter.call(forms, function(form) {
      form.addEventListener("submit", function(event) {
        if (form.checkValidity() === false) {
          event.preventDefault();
          event.stopPropagation();
        }
        form.classList.add("was-validated");
      }, false);
    });
  }, false);
})();
</script>';
 } 

if (!in_array($do, $exclude_html)) {
echo '
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>'.$title.'</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">      
	  <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
	  <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap4.min.css">      
      <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
      
      <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
	  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
	  <script type="text/javascript" language="javascript" src="https://cdn.datatables.net/1.10.23/js/dataTables.bootstrap4.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

<style> </style>

<script> $(document).ready(function() { $("#table").DataTable( { "order": [[ 1, "'.$sort.'" ]], stateSave: true } );} ); </script>

   </head>
   <body>
      <header class="section-header py-4 text-center bg-dark" style="margin-bottom:0">
         <h1 class="text-primary">'.$title.'</h1>
         <p class="text-white">Frontend for gammu-smsd</p>
      </header>
      <nav class="navbar navbar-expand-md navbar-dark bg-primary sticky-top">
         <a class="navbar-brand" href="."><i class="fas fa-sms fa-lg"></i> '.$title.'</a>
         <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
         <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse w-100" id="collapsibleNavbar">
            <ul class="navbar-nav mr-auto">
               <li class="nav-item">
                  <a class="nav-link text-white" href="?do=sent">'; if ($do == "sent") {echo "<b>Sent-Box</b>";} else {echo "Sent-Box";}; echo '
               </a></li>
               <li class="nav-item">
                  <a class="nav-link text-white" href="./?do=inbox">'; if ($do == "inbox") {echo "<b>In-Box</b>";} else {echo "In-Box";}; echo '
               </a></li>
               <li class="nav-item">
                  <a class="nav-link text-white" href="?do=conversation">'; if ($do == "conversation") {echo "<b>Conversations</b>";} else {echo "Conversations";}; echo '
               </a></li>
               <li class="nav-item">
                  <a class="nav-link text-white" href="?do=message">'; if ($do == "message") {echo "<b>Send-SMS</b>";} else {echo "Send-SMS";}; echo '
               </a></li> 
               <li class="nav-item">
                  <a class="nav-link text-white" href="./?do=outbox">'; if ($do == "outbox") {echo "<b>Out-Box</b>";} else {echo "Out-Box";}; echo '
               </a></li>
               <li class="nav-item">
                  <a class="nav-link text-white" href="./?do=log">'; if ($do == "log") {echo "<b>Log</b>";} else {echo "Log";}; echo '
               </a></li>
            </ul>';
if (isset($_SESSION['login']) && $_SESSION['login'] == $hash) {
      echo '<ul class="navbar-nav ml-auto">
               <li class="nav-item">
                  <a class="nav-link text-dark" href="?do=logout"><i class="text-danger fas fa-sign-out-alt"></i> Log-Out</a>
               </li>
            </ul>';
}
   echo '</div>
      </nav>
      <div class="container" style="margin-top:30px; margin-bottom:100px">';
}

if (isset($_SESSION['login']) && $_SESSION['login'] == $hash) {

$dsn = "mysql:host=$host;dbname=$db;charset=$charset"; 
$options = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, PDO::ATTR_EMULATE_PREPARES => false,];

switch ($do) {
//////////////////////////////// * Start inbox * ////////////////////////////////
  case "inbox":
   try {$pdo = new PDO($dsn, $user, $pass, $options);
     $inbox = $pdo->query('SELECT * FROM inbox');
echo '
<h2><i class="text-primary fas fa-download"></i> In-Box</h2>
<p class="text-secondary">In-Box SMS Table:</p>
<table id="table" class="table">
<thead>
   <tr class="bg-primary text-white">
      <th>Number</th>
      <th>Date</th>
      <th>Message</th>
      <th data-orderable="false">Delete</th>
   </tr>
</thead>
<tbody>';
        
foreach($inbox as $row) {
echo '
      <tr>
        <td><i class="text-primary fas fa-mobile-alt"></i><a href="?do=message&phone='.$row['SenderNumber'].'">'.$row['SenderNumber'].'</a></td>
        <td><i class="text-primary fas fa-calendar-alt"></i> '.$row['ReceivingDateTime'].'</td>
        <td><a href="?do=message&message='.urlencode($row['TextDecoded']).'"><i class="text-primary fas fa-comment-alt"></i></a> '.nl2br($row['TextDecoded']).'</td>
        <td><a href="?do=del&table=inbox&id='.$row['ID'].'" title="delete" class="delete" onclick="return confirm('."'". 'Are you sure you want to delete this message' ."'".')"><i class="text-danger far fa-trash-alt"></i></a></td>
      </tr>';
}        
echo '
</tbody>
</table>';
        
} catch (\PDOException $e) {echo "Connection failed: " . $e->getMessage();}
    break;
//////////////////////////////// * End inbox - Start sent * ////////////////////////////////
  case "sent":
   try {$pdo = new PDO($dsn, $user, $pass, $options);
     $sentitems = $pdo->query('SELECT * FROM sentitems');
echo '  
<h2><i class="text-primary fas fa-upload"></i> Sent-Box</h2>
<p class="text-secondary">Sent-Box SMS Table:</p>
<table id="table" class="table">
<thead>
   <tr class="bg-primary text-white">
      <th>Number</th>
      <th>Date</th>
      <th>Message</th>
      <th data-orderable="false">Delete</th>
   </tr>
</thead>
<tbody>';
        
foreach($sentitems as $row) {
echo '
      <tr>
        <td><i class="text-primary fas fa-mobile-alt"></i><a href="?do=message&phone='.$row['DestinationNumber'].'">'.$row['DestinationNumber'].'</a></td>
        <td><i class="text-primary fas fa-calendar-alt"></i> '.$row['SendingDateTime'].'</td>
        <td><a href="?do=message&message='.urlencode($row['TextDecoded']).'"><i class="text-primary fas fa-comment-alt"></i></a> '.nl2br($row['TextDecoded']).'</td>
        <td><a href="?do=del&table=sentitems&id='.$row['ID'].'" title="delete" class="delete" onclick="return confirm('."'". 'Are you sure you want to delete this message' ."'".')"><i class="text-danger far fa-trash-alt"></i></a></td>
      </tr>';
}        
echo '
</tbody>
</table>';        
} catch (\PDOException $e) { echo "Connection failed: " . $e->getMessage();}
    break;
//////////////////////////////// * End sent - Start conversation * ////////////////////////////////
 case "conversation":
   try {$pdo = new PDO($dsn, $user, $pass, $options);
     $chat = $pdo->query("SELECT DISTINCT DestinationNumber FROM sentitems;");
echo"<script>
   $(document).ready(function(){
       $('#mySelect').on('change', function(event){
           event.preventDefault();             
           var formValues= $(this).serialize();
           var actionUrl = $(this).attr('action');    
           $.post(actionUrl, formValues, function(data){
               $('#result').html(data);
           });
       });
   });
</script>";
 
echo '
<h2><i class="text-primary fas fa-comments"></i> Conversations</h2>
<p class="text-secondary">Conversations SMS Table:</p>
<form id= "mySelect" action="?do=view_conversation">
  <div class="form-group">
    <select id="number" name="number" class="custom-select">
    <option value="">Choose Number</option>';
foreach($chat as $row) {
echo '<option value="'.$row['DestinationNumber'].'">'.$row['DestinationNumber'].'</option>';
}

echo'    </select>
  </div>
</form>
<div id="result">
</div>';      
} catch (\PDOException $e) { echo "Connection failed: " . $e->getMessage();}
    break;
//////////////////////////////// * End conversation - Start view_conversation * ////////////////////////////////
 case "view_conversation":
   $number = $_POST['number'];
   try {$pdo = new PDO($dsn, $user, $pass, $options);
     $chat = $pdo->query("SELECT inbox.ReceivingDateTime as 'Date', inbox.SenderNumber as 'Number', inbox.TextDecoded FROM inbox WHERE inbox.SenderNumber = '$number' AND inbox.SenderNumber = '$number' UNION SELECT sentitems.SendingDateTime AS Date, CASE sentitems.DestinationNumber WHEN '$number' THEN '$your_number' END AS Number, TextDecoded FROM sentitems  WHERE sentitems.DestinationNumber = '$number' GROUP BY Date ORDER BY Date;");

echo '
<script>
$(document).ready(function() {
    $("#table").DataTable( {
        "order": [[ 1, "'.$sort.'" ]],
        stateSave: true,
        "searching": false
    } );
} );
</script>

<table id="table" class="table table-striped">
<thead>
   <tr class="bg-primary text-white">
      <th>Number</th>
      <th>Date</th>
      <th>Message</th>
   </tr>
</thead>
<tbody>';        

foreach($chat as $row) {
echo '
      <tr>
        <td><i class="text-primary fas fa-mobile-alt"></i> <a href="?do=message&phone='.$row['Number'].'">'.$row['Number'].'</a></td>
        <td><i class="text-primary fas fa-calendar-alt"></i> '.$row['Date'].'</td>
        <td><i class="text-primary fas fa-comment-alt"></i> '.nl2br($row['TextDecoded']).'</td>
      </tr>';
}
        
echo '
</tbody>
</table>';        
} catch (\PDOException $e) { echo "Connection failed: " . $e->getMessage();}
    break;
//////////////////////////////// * End view_conversation - Start message * //////////////////////////////// 
 case "message":
echo"
<script>
   $(document).ready(function(){
       $('form').on('submit', function(event){
           event.preventDefault();    
           var formValues= $(this).serialize();
           var actionUrl = $(this).attr('action');    
           $.post(actionUrl, formValues, function(data){
               $('#result').html(data);
           });
       });
   });
</script>";

echo '
<h2><i class="text-primary fas fa-sms"></i> Send SMS</h2>
<p class="text-secondary">Send SMS Form</p>
<form action="?do=send_message">
   <div class="form-group">
      <label class="text-primary fas fa-mobile-alt" for="phone"> Phone:</label>
      <input type="text" class="form-control" id="phone" name="phone" value="'.urlencode($_GET['phone']).'">
   </div>
   <div class="form-group">
      <label class="text-primary fas fa-comment-alt" for="message"> Message:</label>
      <textarea class="form-control" rows="5" id="message" name="message">'.$_GET['message'].'</textarea>
   </div>
   <button type="submit" value="submit" class="btn btn-primary text-dark">Submit</button>
</form>

<div id="result">
</div>'; 
    break;
//////////////////////////////// * End message - Start send_message * ////////////////////////////////
 case "send_message":
$phone = $_POST['phone']; $message = $_POST['message'];

if (empty($phone))
    $errors['phone'] = '
</br>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
   Phone is required.!
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
   <span aria-hidden="true">&times;</span>
   </button>
</div>';

if (empty($message))
    $errors['message'] = '
</br>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
   Message is required!
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
   <span aria-hidden="true">&times;</span>
   </button>
</div>';

if ( ! empty($errors)) {
    $data['errors']  = $errors;
} else {
$phone = filter_var($phone, FILTER_SANITIZE_NUMBER_INT); $message = escapeshellarg($message);

$send = shell_exec("gammu-smsd-inject TEXT $phone -unicode -$get_text $message").PHP_EOL;
echo '
</br>
<div class="alert alert-success alert-dismissible fade show" role="alert">'
   .$send.
   '<button type="button" class="close" data-dismiss="alert" aria-label="Close">
   <span aria-hidden="true">&times;</span>
   </button>
</div>';

}
foreach ($data['errors'] as $value) {echo $value;}
    break;

 case "logout":
unset($_SESSION['login']); header("Location: $_SERVER[PHP_SELF]");
    break;

 case "outbox":
   try {$pdo = new PDO($dsn, $user, $pass, $options);
     $outbox = $pdo->query('SELECT * FROM outbox');
echo '  
<h2><i class="text-primary fas fa-upload"></i> Out-Box</h2>
<p class="text-secondary">Outbox-Box SMS Table:</p>
<table id="table" class="table">
<thead>
   <tr class="bg-primary text-white">
      <th>Number</th>
      <th>Date</th>
      <th>Message</th>
      <th data-orderable="false">Delete</th>
   </tr>
</thead>
<tbody>';
        
foreach($outbox as $row) {
echo '
      <tr>
        <td><i class="text-primary fas fa-mobile-alt"></i><a href="?do=message&phone='.$row['DestinationNumber'].'">'.$row['DestinationNumber'].'</a></td>
        <td><i class="text-primary fas fa-calendar-alt"></i> '.$row['SendingDateTime'].'</td>
        <td><a href="?do=message&message='.urlencode($row['TextDecoded']).'"><i class="text-primary fas fa-comment-alt"></i></a> '.nl2br($row['TextDecoded']).'</td>
        <td><a href="?do=del&table=outbox&id='.$row['ID'].'" title="delete" class="delete" onclick="return confirm('."'". 'Are you sure you want to delete this message' ."'".')"><i class="text-danger far fa-trash-alt"></i></a></td>
      </tr>';
}        
echo '
</tbody>
</table>';        
} catch (\PDOException $e) { echo "Connection failed: " . $e->getMessage();}
    break;
//////////////////////////////// * End send_message - Start log * ////////////////////////////////
 case "log":
echo '
<h2><i class="text-primary fas fa-sms"></i> SMSD Log</h2>
<p class="text-secondary">SMSD Log</p>
   <div class="form-group">
      <textarea class="form-control" rows="20" id="message" name="message">'; 

$file = file($log) or print("Unable to open log file!");
for ($i = max(0, count($file)-$max_log_lines); $i < count($file); $i++) {
  echo $file[$i];
}
echo '</textarea>
   </div>'; 
    break;

  case "del":
   try {$pdo = new PDO($dsn, $user, $pass, $options);
                
        $id = $_GET['id'];
        $table = $_GET['table'];
        
        $stmt = $pdo->prepare( "DELETE FROM $table WHERE id =:id" );
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        if( ! $stmt->rowCount() ) {
        echo "<script> alert('Delete Failed'); window.history.back(); </script>";
        } else {echo "<script>window.history.back(); </script>";}         
} catch (\PDOException $e) { echo "Delete failed: " . $e->getMessage();}
    break;
//////////////////////////////// * End log - Start default * ////////////////////////////////
default:
    echo '
<h2 class="mb-sm-5"><i class="text-primary fas fa-sms"></i> '.$title.'</h2>
    <div class="list-group">
  <a href="?do=sent" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Sent Box</h5>
    </div>
    <p class="mb-1">Displays list of sent SMS. From the database "sentitems" table.</p>
  </a>
  <a href="?do=inbox" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">In Box</h5>
    </div>
    <p class="mb-1">Displays list of received SMS. From the database "inbox" table.</p>
  </a>
  <a href="?do=conversation" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Conversations</h5>
    </div>
    <p class="mb-1">Query join of the database "inbox" and "senditens" tables to display list of available conversations</p>
  </a>  
    <a href="?do=outbox" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Out Box</h5>
    </div>
    <p class="mb-1">Displays list of OutBox (Queued For Delivery) SMS. From the database "outbox" table.</p>
  </a>  
  <a href="?do=message" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Send SMS</h5>
    </div>
    <p class="mb-1">Form for sending SMS.</p>
  </a>
  <a href="#" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">SMS Send API</h5>
    </div>
    <p class="mb-1">Send sms from command line. Example: http://localhost/?do=api&token=your_token&phone=to_phone&message=your_message</p>
  </a>
  <a href="?do=log" class="list-group-item list-group-item-action flex-column align-items-start">
    <div class="d-flex w-100 justify-content-between">
      <h5 class="mb-1">Log</h5>
    </div>
    <p class="mb-1">Displays the smsd log file</p>
  </a>
</div>';
  }
//////////////////////////////// * End default * ////////////////////////////////

}
else if (isset($_POST['submit'])) {
	if ($_POST['username'] == $username && $_POST['password'] == $password){
		$_SESSION["login"] = $hash;
		header("Location: $_SERVER[PHP_SELF]");		
} else { display_login_form();
		echo '
  </br>      
  <div class="alert alert-danger alert-dismissible fade show">
    <button type="button" class="close" data-dismiss="alert">&times;</button>
    Username or Password Invalid!
  </div>';
		
	}
} else { display_login_form(); }

if (!in_array($do, $exclude_html)) {

echo'
</div>
  <footer class="footer fixed-bottom py-4 bg-dark text-white">
    <div class="container text-center text-primary">
      <small>'.$footer.'</small>
    </div>
  </footer>
  </body>
</html>';
}
?>
