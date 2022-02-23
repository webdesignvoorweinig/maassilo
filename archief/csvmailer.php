<?php

require_once 'core/init.php';

// knop vanuit eindtelling stuurt id van event mee. op basis daarvan de csv maken.

$actualstock = DB::getinstance()->query_assoc("select f.event_name, f.event_date, fm.eventid, fm.barid, fm.drankid, d.drankid, d.drank_naam, d.drank_vol, fm.begin, fm.eind
FROM events f
JOIN voorraad fm ON f.eventid = fm.eventid 
JOIN dranken d ON fm.drankid = d.drankid
WHERE f.event_date = '2022-01-13' ORDER BY fm.barid ASC");

$rows = $actualstock->results();

function create_csv_string($data2) {

    // Open temp file pointer
    if (!$fp = fopen('php://temp', 'w+')) return FALSE;
    fputcsv($fp, array('Evenement', 'Evenement Datum', 'Evenement ID', 'Bar ID', 'Drank ID', 'Drank Naam', 'Drank Volume', 'Begin Telling', 'Eind Telling'), ";");
    // Loop data and write to file pointer
    foreach ($data2 as $line) fputcsv($fp, $line, ";");
  
    // Place stream pointer at beginning
    rewind($fp);
  
    // Return the data
    return stream_get_contents($fp);
  
  }
  
  
  function send_csv_mail ($csvData, $body, $to = 'marc.meijer82@gmail.com',  $from = 'info@webdesignvoorweinig.nl',$subject = 'Voorraadlijst test' ) {
  
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
          . "Content-Disposition: attachment; filename=\"voorraadlijst.csv\"\r\n" // hier nog bestandsnaam genereren.
          . "\r\n"
          . "$attachment\r\n"
          . "--$multipartSep--";
  
     // Send the email, return the result
     //return @mail($to, $subject, $body, implode("\r\n", $headers)); 
  
  }
  
    
  
  echo "emaling now <br>";
  $resp=send_csv_mail($rows, "Voorraadlijst van Evenement:");
   
  if( $resp ){
  echo "Mail sent <br>" ;
  } else {
  echo "Mail not sent <br>";
  }
  echo "fin <br>";
  




?>
