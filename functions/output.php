<?php

function getbeverages(){
    $beverages = DB::getInstance()->get("dranken");
    $bev="";
	foreach($beverages->results() as $beverage) {
    
$bev .= '
<section class="container voorraad">
  <div class="drank__naam">
    '.$beverage->drank_naam.'
  </div>
  <div class="drank__vol">
    ' .$beverage->drank_vol.'
  </div>
  <div class="begintelling">
    <input type="text" name="drank['.$beverage->drankid.'][precount]" class="form-control" style="width:4rem;">
  </div>
  <div class="opmerking">
    <textarea cols="30" rows="2" name="drank['.$beverage->drankid.'][remarks]" class="form-control"></textarea>
  </div>
  <div class="controle">
    <input type="text" name="drank['.$beverage->drankid.'][check]" class="form-control">
  </div>
</section>';
 
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