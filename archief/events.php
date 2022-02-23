<?php
	require_once 'core/init.php';
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voorraad lijsten Maassilo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script>
    	$(document).ready(function(){
        	$(document).on("submit","#cevent", function(event) {
            	var request;
                event.preventDefault();
        		var values = $(this).serialize();
        		
        		request = $.ajax({
           		 	url: "process.php?a=cevent",
            		type: "post",
            		data: values,
                	cache: false,
                	async: true
        		});
            	
        		request.done(function (response, textStatus, jqXHR){
         		// show succes message
         		$("#result").html('event succesvol aangemaakt');
                
            	$("#selectevent").load(location.href+" #selectevent>*","");
                $("#createevent").load(location.href+" #createevent>*","");
                
                });
        		
        		request.fail(function (){

        		// Show error
        		$("#result").html('There is error while submit');
    			});
				
             });
        	// bepalen welke submit button is geklikt
        	var postcount;
            $(".sbmt").click(function(){
                	postcount = $(this).attr('name');
            });
        
        	$(document).on("submit", "#gevents", function(event){
            
            	var getrequest;
            	event.preventDefault();
            
            	//alert(postcount);
            
            	var gvalues = $(this).serialize();
             	// op basis van de naam van de submit button de juiste actie uitvoeren.
            	if(postcount == "getevent"){
            	getrequest = $.ajax({
                	url: "process.php?a=gevent",
                	type: "post",
                	data: gvalues,
                	cache: false
                });
               
                } // als het de eindtellijst is hier het ajax request maken voor de update data.
            	else {
                	$("#stock").html("hier komt update data");
                }
            	getrequest.done(function (response, textStatus, jqXHR){
                	$("#stock").html(response);
                	
                });
            
            	getrequest.fail(function (){

        		// Show error
        		$("#stock").html('There is error while submit');
    			});
            });
        
        	$(document).on("submit", "#prestock", function(event){
            	var postrequest;
            	event.preventDefault();
            	var pvalues = $(this).serialize();
            	
            	postrequest = $.ajax({
                	url: "process.php?a=prestock",
                	type: "post",
                	data: pvalues,
                	cache: false
                });
            
            	postrequest.done(function (response, textStatus, jqXHR){
                	$("#tmp").html(response);
                });
            
            	postrequest.fail(function(){
                	$("#tmp").html("there is something wrong");	
                });
            
            });
        
                        
        });
	</script>
</head>
<body>

<h2>Select Event :</h2>
<div id="selectevent">
<form id="gevents">
<select name="event" id="events">
<?php
	$current_date = date('y-m-d');
	$getevents = DB::getInstance()->get('events', array( 
    	'event_date',
    	'=',
    	$current_date
    ));
	print_r($getevents);
	foreach($getevents->results() as $e){
		
?>
	<option name="eventid" value="<?php echo $e->eventid; ?>"><?php echo "datum: " .date("d-m-y", strtotime($e->event_date)). " event: " .$e->event_name; ?></option>

<?php } ?>
</select>
<input type="submit" class="sbmt" name="getevent" value="Ga naar begin tellijst">
<input type="submit" class="sbmt" name="postevent" value="Ga naar eind tellijst">
</form>

</div>

<div id="result"></div>
<div id="createevent">
<form id="cevent">
<h2> Create New Event</h2>
<input type="text" name="event_name">
<input type="hidden" name="event_date" value="<?php echo $current_date; ?>">
<input type="submit" name="submitevent" value="Create Event">
</form>
</div>
<div id="stock">
</div>
<div id="tmp">
</div>
</body>
</html>
