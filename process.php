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
    	
    	$newstock = new Stock($_POST['event']);
    	echo $newstock->prestock();
    
    }

	if($_GET['a'] === "prestock") {
    
    	extract($_POST);
		if(!empty($bar)):
    		$prest = new Stock($_POST['event']);
    		echo $prest->save_prestock($bar, $barleader, $drank);
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
		print_r($_POST);
		$qustock = new Stock();
		$ustock = $qustock->save_poststock($_POST);
	}

?>