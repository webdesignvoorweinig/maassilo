<?php

function getbeverages(){
    $beverages = DB::getInstance()->get("dranken");
    $bev="";
	foreach($beverages->results() as $beverage) {
    
$bev .= '
<div class="row mb-2">
<div class="col-2">'.$beverage->drank_naam.'</div>
<div class="col-2 ps-4">'. $beverage->drank_vol.'</div>
<div class="col-1 ps-4 me-5"><input type="text" name="drank['.$beverage->drankid.'][precount]"  class="form-control" style="width:4rem;"></div>
<div class="col-lg-2 col-md-3 ps-5 me-5"><textarea cols="30" rows="2" name="drank['.$beverage->drankid.'][remarks]"  class="form-control"></textarea></div>
<div class="col-lg-2 col-md-3 ps-5"><input type="text" name="drank['.$beverage->drankid.'][check]" class="form-control"></div>
</div>
';
 
	}
	return $bev;
}

function getbars(){
	$bars = DB::getInstance()->get('bar');
	$some = '<select name="bar" id="bars" class="form-select">
				<option value=""></option>';

	foreach($bars->results() as $bar){
    $some .= '
  	<option value="'.$bar->barid.'">'.$bar->bar_nr.'</option>';
    
    }
	$some .='</select>';
	return $some;
}
?>