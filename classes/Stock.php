<?php

class Stock extends DB{

    private $stock;
    private $drinks;
    private $bars;
	private $eventid;

	public function __construct($id=0) {
    	$this->eventid = $id;
    	
    }

	public function prestock(){
   
    	$prestock = DB::getInstance()->get('events', array('eventid', '=', $this->eventid));
    	
        $output = '
        <form id="prestock" class="container-fluid mt-5">
		<section class="container info">
		<div class="event__name">
		  <h4>Evenement: </h4>
		  <h5>'.$prestock->results()[0]->event_name. '</h5>
		</div>
		<div class="event__date">
		  <h4>Datum:</h4>
		  <h5>' .$prestock->results()[0]->event_date. '</h5>
		</div>
		<div class="event__bar">
		  <h4>Selecteer Bar:</h4>
		  ' .getbars().'
		  <input type="hidden" name="event" value="' .$this->eventid.'">
		</div>
	  </section>
	  
	  <section class="container tellijst">
		<div class="tellijst__headers">
		  <h4>Drank</h4>
		</div>
		<div class="tellijst__headers">
		  <h4>Volume</h4>
		</div>
		<div class="tellijst__headers">
		  <h4>Begintelling</h4>
		</div>
		<div class="tellijst__headers">
		  <h4>Opmerkingen</h4>
		</div>
		<div class="tellijst__headers">
		  <h4>Controle</h4>
		</div>
	  </section>
	  '.getbeverages().'
	  <div class="container voortelling">
		<input type="submit" class="btn btn-msilo" name="precount" value="voortelling opslaan">
	  </div>
	  </form>'; 
    	return $output;
    }

	

	public function save_prestock($bar, $drank=array()){
    	
    	// pre check uitvoeren of er al een bar bestaat op dit evenement
    	$precheck = DB::getInstance()->query("SELECT eventid, barid FROM voorraad WHERE barid = $bar AND eventid = $this->eventid");
    	// als de bar nog niet bestaat dan mag je de begintelling toevoegen.
    	if($precheck->rows() == 0) { 
        	foreach($drank as $drankid => $drankitems){
				if(empty($drankitems['precount'])):
					$drankitems['precount'] = 0;
				endif;
            	$insertprestock = DB::getInstance()->insert('voorraad', array(
            	"eventid" => $this->eventid,
            	"barid" => $bar,
            	"drankid" => $drankid,
            	"begin" => $drankitems['precount'],
            	"opmerking" => $drankitems['remarks'],
            	"control" => $drankitems['check']
            ));	
				
        	}
			
			$msg = "Begintelling voorraad succesvol opgeslagen";
        
        } 
        else {
        	// de bar bij het desbetreffende evenement bestaat al en kan dus niet dubbel toegevoegd worden
        	$msg = "voor dit evenement is er al een bar gekoppeld met naam: ". $bar . " Heb je een correcte bar geselecteerd?";
        	
        }
		return $msg;
	}

	public function poststock($barid) {
    	$sql = "SELECT e.eventid, e.event_name, e.event_date, f.eventid, f.voorraadid, f.barid, f.opmerking, f.control, f.drankid, d.drankid, d.drank_naam, d.drank_vol, f.begin, f.eind
				FROM voorraad f
                JOIN dranken d ON f.drankid = d.drankid
                JOIN events e ON e.eventid = f.eventid
                WHERE f.eventid = {$this->eventid} AND f.barid = {$barid}";
        $poststock = DB::getInstance()->query($sql);
    	if($poststock->rows() != 0) {
        
    	$output = '<form id="pcount" class="container-fluid mt-5">
		<section class="container info">
		<div class="event__name">
		  <h4>Evenement: </h4>
		  <h5>'.$poststock->results()[0]->event_name. '</h5>
		</div>
		<div class="event__date">
		  <h4>Datum:</h4>
		  <h5>' .$poststock->results()[0]->event_date. '</h5>
		</div>
		<div class="event__bar">
		  <h4>Bar:</h4>
		  ' .$poststock->results()[0]->barid.'
		</div>
	  </section>
	  
	  <section class="container natellijst">
		<div class="tellijst__headers">
		  <h4>Drank</h4>
		</div>
		<div class="tellijst__headers">
		  <h4>Volume</h4>
		</div>
		<div class="tellijst__headers">
		  <h4>Begintelling</h4>
		</div>
		<div class="tellijst_headers">
			<h4>Eindtelling</h4>
		</div>
		<div class="tellijst__headers">
		  <h4>Opmerkingen</h4>
		</div>
		<div class="tellijst__headers">
		  <h4>Controle</h4>
		</div>
	  </section>
	  <section class="container navoorraad">';
    
    	foreach($poststock->results() as $pstock) {
        	$vid = $pstock->voorraadid;
			$output .= '<div class="drank__naam">
            '.$pstock->drank_naam.'
          </div>
          <div class="drank__vol">
            ' .$pstock->drank_vol.'
          </div>
          <div class="begintelling">
            '.$pstock->begin.'
          </div>
		  <div class="eindtelling">
		  	<input type="text" name="voorraad['.$vid.'][eind]" class="form-control" style="width:4rem;">
		  </div>
          <div class="opmerking">
		  	<textarea name="voorraad['.$vid.'][remark]" class="form-control">'.$pstock->opmerking.'</textarea>
          </div>
          <div class="controle">
            '.$pstock->control.'
          </div>';
            	
        }
    	$output .= '</section>
		<div class="container voortelling">
			<input type="hidden" name="eventid" value="'.$this->eventid.'">
			<input type="submit" class="sbmt btn btn-msilo" name="updatevent" value="Eindtelling Opslaan">
		</div>
		</form>';
	} else {
		$output = "Voor deze bar staan er geen tellingen in het systeem";
	}
    	return $output;
    	  
    }
	
	public function save_poststock($params) {
		foreach($params['voorraad'] as $vid => $stock){
			$sql = "UPDATE voorraad SET eind = ?, opmerking = ? WHERE voorraadid = ?";
			$sstock = DB::getInstance()->query($sql, array($stock['eind'],$stock['remark'],$vid));
		}
		// records updaten met nieuwe data. we moeten hiervoor het id hebben van het record voorraad.
		// $sql = "UPDATE voorraad SET eind = ?, opmerking = ? WHERE voorraadid = ?"
		// $sstock = DB::getInstance()->query($sql, $params)
	}
    
}
?>