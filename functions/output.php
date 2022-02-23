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

function create_csv_string($data2) {

  // Open temp file pointer
  if (!$fp = fopen('php://temp', 'w+')) return FALSE;
  fputcsv($fp, array('Drank', 'Volume', 'Begintelling', 'Eindtelling', 'Opmerking', 'Controle', 'Bar Nr'), ";");
  // Loop data and write to file pointer
  foreach ($data2 as $line) fputcsv($fp, $line, ";");

  // Place stream pointer at beginning
  rewind($fp);

  // Return the data
  return stream_get_contents($fp);

}


function send_csv_mail ($csvData, $filename, $body, $to = 'marc.meijer82@gmail.com',  $from = 'info@webdesignvoorweinig.nl',$subject = 'Voorraadlijst test' ) {

  // This will provide plenty adequate entropy
  $multipartSep = '-----'.md5(time()).'-----';

  // Arrays are much more readable
  $headers = array(
    "From: $from",
    "Reply-To: $from",
    "Content-Type: multipart/mixed; boundary=\"$multipartSep\""
  );

  // Make the attachment
 
 $attachment = chunk_split(base64_encode(create_csv_string($csvData))); 

  // Make the body of the message
  $body = "--$multipartSep\r\n"
        . "Content-Type: text/plain; charset=ISO-8859-1; format=flowed\r\n"
        . "Content-Transfer-Encoding: 7bit\r\n"
        . "\r\n"
        . "$body\r\n"
        . "--$multipartSep\r\n"
        . "Content-Type: text/csv\r\n"
        . "Content-Transfer-Encoding: base64\r\n"
        . "Content-Disposition: attachment; filename=\"$filename\"\r\n" 
        . "\r\n"
        . "$attachment\r\n"
        . "--$multipartSep--";

   // Send the email, return the result
   return @mail($to, $subject, $body, implode("\r\n", $headers)); 
  
}

  


?>