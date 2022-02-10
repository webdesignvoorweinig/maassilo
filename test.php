<?php
    require_once 'core/init.php';

 	$actualstock = DB::getinstance()->query_assoc("select f.event_name, f.event_date, fm.eventid, fm.barleader, fm.barid, fm.drankid, d.drankid, d.drank_naam, d.drank_vol, fm.begin, fm.eind
FROM events f
JOIN voorraad fm ON f.eventid = fm.eventid 
JOIN dranken d ON fm.drankid = d.drankid
WHERE f.event_date = '2022-01-13' ORDER BY fm.barid ASC");

$rows = $actualstock->results();

$filename = 'voorraadlijst'.$rows[0]['event_name'].'-bar nr:'.$rows[0]['barid'];


//header("Content-Type: application/xls");    
//header("Content-Disposition: attachment; filename=$filename.xls");  
//header("Pragma: no-cache"); 
//header("Expires: 0");

$separator = "\t"; 

if(!empty($rows)){
    
    //Dynamically print out the column names as the first row in the document.
    //This means that each Excel column will have a header.
    echo '<pre>' .implode($separator, array_keys($rows[0])) . "\n". ' </pre>';
    
    //Loop through the rows
    foreach($rows as $row){
       // print_r( $row );
        //Clean the data and remove any special characters that might conflict
        foreach($row as $k => $v){
        	
       		//if($k != 'event_name' && $k != 'event_date' && $k != 'barid' && $k != 'drankid' && $k != 'eventid' && $k != 'barleader'){
            
        	$row[$k] = str_replace($separator . "$", "", $row[$k]);
            $row[$k] = preg_replace("/\r\n|\n\r|\n|\r/", " ", $row[$k]);
            $row[$k] = trim($row[$k]);
            //} //else {
            	//kolommen verwijderen die niet nodig zijn in excel
            //	unset($row[$k]);
           // }
        }
        
        //Implode and print the columns out using the 
        //$separator as the glue parameter
        echo "<pre>";
        echo implode($separator, $row) . "\n";
        echo "</pre>";
    }
}



?>