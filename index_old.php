<?php 
		require_once 'core/init.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voorraad lijsten Maassilo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
	
</head>
<body>
    <header>
	<?php
    	if($_POST){
        echo '<pre>';
        //	print_r($_POST);
        echo '</pre>';
        
        
    	$create_event = DB::getInstance()->insert('events', array(
        	'event_name' => $_POST['eventname'],
            'event_date' => $_POST['datum']
        ));
        
 		$lastid = DB::getInstance()->query("SELECT MAX(eventid) AS eventid FROM events");
        print_r($lastid->results());
        foreach($lastid->results() as $result){
        	echo $result->eventid;
        }
      
       
		
        }
    // stappen te maken, bij post event aanmaken, id retour voor stock tabel te vullen.
    ?>
   
        <nav class="navlist">
            <ul>
                <li><a href="index.php">Begintelling</a></li>
                <li><a href="update.php">Eindtelling</a></li>
                <li><a href="export.php">Export voorraad</a></li>
                <li></li>
                <li></li>
            </ul>
        </nav>
        <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
        <div class="listgrid">
            <div class="event-header"><h2>Date: </h2><input type="date" name="datum"></div>
            <div class="event-header grid-col-span-2">
            	<h2>Event: </h2><input type="text" name="eventname">
        	</div>
            <div class="event-header grid-col-span-2">
            	<h2>Barhoofd: </h2>
            	<input type="text" name="barleader">
        	</div>
            <div class="event-header grid-col-span-2">
            	<h2>Bar: </h2>
        		<?php getbars(); ?>
        	</div>
            <div class="event-header">Begin Telling</div>
            <div class="event-header">Opmerkingen</div>
            <div class="event-header">Controle</div>
     
            <?php getbeverages(); ?>
       
       </div>         
       <div class="save-data">
           <input type="submit" value="Opslaan">
           <!-- on submit data wegschrijven naar database-->
       </div>
    </form>
    </header>
</body>
</html>
