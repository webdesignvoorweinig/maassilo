<?php
	require_once 'core/init.php';
	if($_GET['a'] === "cevent"){
		if(!empty($_POST['event_name'])):
		$create_event = DB::getInstance()->insert('events', array(
        	'event_name' => $_POST['event_name'],
            'event_date'=> $_POST['event_date']
        ));
	else:
		echo "Je bent vergeten een naam voor je event in te vullen";
	endif;
	
    }

	if($_GET['a'] === "gevent"){
    	if(!empty($_POST['event'])):
    		$newstock = new Stock($_POST['event']);
    		echo $newstock->prestock();
		else:
			echo "Je hebt geen evenement geselecteerd of aangemaakt!";
		endif;

    }

	if($_GET['a'] === "prestock") {
    
    	extract($_POST);
		
		if(!empty($bar)):
		
    		$prest = new Stock($_POST['event']);
    		echo $prest->save_prestock($bar, $drank);
			
		else:
		 	echo "Je bent vergeten het bar nr in te geven!";
		endif;
    }

	if($_GET['a'] === "pevent") {
		if(!empty($_POST['bar'])):
    		$poest = new Stock($_POST['event']);
    		$eind = $poest->poststock($_POST['bar']);
    		echo $eind;
		else:
			echo "Je bent vergeten een bar te selecteren";
		endif;
    }

	if($_GET['a'] === "ustock"){
		
		$qustock = new Stock();
		$ustock = $qustock->save_poststock($_POST);
		
		echo "Eindtelling Succesvol Opgeslagen";
	}

	if($_GET['a'] === "getcsv") {

		// $newcsv = DB::getInstance()->get('voorraad', array('eventid', '=', $_POST['event']));
		$newcsv = DB::getInstance()->query("SELECT eventid, barid FROM voorraad WHERE eventid = '".$_POST['event']."' GROUP BY barid");
		$checkdata = $newcsv->results();
		$res = '
			<div>
				<h4>Wij hebben voorraadlijsten van de volgende barren voor dit evenement:</h4>
			</div>
			<div>
		';
		
		foreach($checkdata as $check){
			$res .= '<h5>Bar Nr :'.$check->barid.'</h5>';

		}
		$res .= '
			<hr></hr>
			<div>
				<p>Als deze data niet klopt ga dan terug en vul de lijst van de ontbrekende bar aan!</p>
			</div>
			</div>
			<div>
				<form id="sendcsv"> 
					<input type="hidden" name="event" value="'.$newcsv->results()[0]->eventid.'">
					<input type="submit" name="subcsv" class="btn btn-msilo" value="Versturen naar Administratie">
				</form>		
			</div>	
			';
		echo $res;
	}

	if($_GET['a'] == "sendcsv"){
		$evname = DB::getInstance()->get('events', array('eventid', '=', $_POST['event']));
		$eid = $evname->results()[0]->event_name;
		$csvq = DB::getInstance()->query_assoc("
		SELECT d.drank_naam, d.drank_vol, fm.begin, fm.eind, fm.opmerking, fm.control, fm.barid
		FROM voorraad fm
		JOIN dranken d ON fm.drankid = d.drankid
		WHERE fm.eventid = ".$_POST['event']." ORDER BY fm.barid ASC 
		");
		$rows = $csvq->results();
		
		$resp = send_csv_mail($rows, "Voorraadlijst-".$eid.".csv", "Voorraadlijst csv attached", "nathalie@maassilo.com", "info@maassilo.com" , "Voorraadlijst-".$eid);
		if( $resp ){
			$msg = 'Lijst succesvol verstuurd';
		} else {
			$msg = "Er is iets mis gegaan kon de email niet sturen";
		}
		echo $msg;
			
	}

?>