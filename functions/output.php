<?php

function getbeverages(){
    /*$beverages = DB::getInstance()->query("SELECT * FROM beverages");*/
    // array uiteindelijk vervangen door database query
    $beverages = array(array("beverageid" => "1", "beverage_name" => "pepsi", "beverage_vol" => "28x20cl"),
                 array("beverageid" => "2", "beverage_name" => "appelsap", "beverage_vol" => "10x33cl"));
  // print_r($beverages);
   foreach($beverages as $beverage) {
    
   

echo <<<html
<div class="beverage">{$beverage['beverage_name']}</div>
<div class="beverage">{$beverage['beverage_vol']}</div>
<div class="pre-count"><input type="text" name="drank[{$beverage['beverageid']}][precount]"></div>
<div class="post-count"><input type="text" name="drank[{$beverage['beverageid']}][postcount]"></div>
<div class="remarks"><textarea cols="30" rows="3" name="drank[{$beverage['beverageid']}][remarks]"></textarea></div>
<div class="check"><input type="text" name="drank[{$beverage['beverageid']}][check]"></div>
html;
 
}
}
?>