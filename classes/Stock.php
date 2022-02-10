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
        	<div class="row mb-3">
            	<div class="col-3"><h4>Evenement : '.$prestock->results()[0]->event_name. '</h4></div>
                <div class="col-2"><h4>Datum : '.$prestock->results()[0]->event_date.'</h4></div>            
                <div class="col-2 d-flex">
                
                	<div class="me-3">
                	<h4>Selecteer Bar:</h4> 
                    </div>
                    <div>
                    '.getbars().'
                    </div>
                
                </div>
                <div class="col-3 d-flex">
                	<div class="me-3">
                		<h4>Barhoofd : </h4>
                	</div>
                	<div class="col-6">
                		<input type="text" name="barleader" class="form-control">
                   		<input type="hidden" name="event" value="'.$this->eventid.'">
                 	</div>
                 </div>
            </div>
      		<div class="row mb-3" style="border-bottom:2px solid navy;">
            	<div class="col-2"><h5>Drank</h5></div>
            	<div class="col-2"><h5>Volume</h5></div>
            	<div class="col-1 me-5"><h5>Begintelling</h5></div>
            	<div class="col-lg-2 col-md-3 ps-5 me-5"><h5>Opmerkingen</h5></div>
            	<div class="col-lg-2 col-md-3 ps-5"><h5>Controle</h5></div>
      		</div>'
    			.getbeverages().'	
        	<div class="row">
            	<div class="col">	
            		<input type="submit" class="btn btn-success" name="precount" value="voortelling opslaan">
        		</div>
            </div>
        </form>'; 
    	return $output;
    }

	

	public function save_prestock($bar, $barleader, $drank=array()){
    	
    	// pre check uitvoeren of er al een bar bestaat op dit evenement
    	$precheck = DB::getInstance()->query("SELECT eventid, barid FROM voorraad WHERE barid = $bar AND eventid = $this->eventid");
    	// als de bar nog niet bestaat dan mag je de begintelling toevoegen.
    	if($precheck->rows() == 0) { 
        	foreach($drank as $drankid => $drankitems){
            	$insertprestock = DB::getInstance()->insert('voorraad', array(
            	"eventid" => $this->eventid,
            	"barid" => $bar,
            	"barleader" => $barleader,
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
    	$sql = "SELECT e.eventid, e.event_name, e.event_date, f.eventid, f.voorraadid, f.barleader, f.barid, f.opmerking, f.control, f.drankid, d.drankid, d.drank_naam, d.drank_vol, f.begin, f.eind
				FROM voorraad f
                JOIN dranken d ON f.drankid = d.drankid
                JOIN events e ON e.eventid = f.eventid
                WHERE f.eventid = {$this->eventid} AND f.barid = {$barid}";
        $poststock = DB::getInstance()->query($sql);
    	
    	$output = '<form id="pcount" class="container-fluid mb-5">
        	<div class="row mb-3">
            	<div class="col-3"><h4>Evenement : '.$poststock->results()[0]->event_name. '</h4></div>
                <div class="col-2"><h4>Datum : '.$poststock->results()[0]->event_date.'</h4></div>            
                <div class="col-2 d-flex">
                
                	<div class="me-3">
                	<h4>Bar:</h4> 
                    </div>
                    <div><h4>
                    '.$poststock->results()[0]->barid.'
                    </h4>
                    </div>
                
                </div>
                <div class="col-3 d-flex">
                	<div class="me-3">
                		<h4>Barhoofd : </h4>
                	</div>
                	<div class="col-6"><h4>
                		'.$poststock->results()[0]->barleader.'
                 	</h4></div>
                 </div>
            </div>
      		<div class="row mb-3" style="border-bottom:2px solid navy;">
            	<div class="col-2"><h5>Drank</h5></div>
            	<div class="col-2"><h5>Volume</h5></div>
            	<div class="col-1 me-5"><h5>Begintelling</h5></div>
                <div class="col-2"><h5>Eindtelling</h5></div>
            	<div class="col-lg-2 col-md-3 ps-5 me-5"><h5>Opmerkingen</h5></div>
            	<div class="col-lg-2 col-md-3 ps-5"><h5>Controle</h5></div>
      		</div></div>';
    
    	foreach($poststock->results() as $pstock) {
        	$vid = $pstock->voorraadid;
			$output .= '
            	<div class="row">
            	<div class="col-2">'.$pstock->drank_naam.'</div>
                <div class="col-2">'.$pstock->drank_vol.'</div>
                <div class="col-1 me-5">'.$pstock->begin.'</div>
                <div class="col-2"><input type="text" name="voorraad['.$vid.'][eind]"></div>
                <div class="col-lg-2 col-md-2 ps-5 me-5"><textarea name="voorraad['.$vid.'][remark]">'.$pstock->opmerking.'</textarea></div>
                <div class="col-lg-2 col-md-3 ps-5">'.$pstock->control.'</div>
            	</div>
            ';
        }
    	$output .= '
		<input type="submit" class="sbmt btn btn-success" name="updatevent" value="Eindtelling Opslaan">
		</form>';
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