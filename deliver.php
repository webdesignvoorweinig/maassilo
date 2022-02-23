<?php
require_once 'inc/headerinc.php';

?>
<section class="container events">
  <form id="geventsdata" class="selectevent events__select">
    <h3>Selecteer Evenement</h3>
    <select name="event" id="events" class="form-select">
      <?php
        $current_date = date('y-m-d');
        $getevents = DB::getInstance()->get('events', array( 
          'event_date',
          '=',
          $current_date
        ));
      
      foreach($getevents->results() as $e){
      ?>
      <option name="eventid" value="<?php echo $e->eventid; ?>"><?php echo "Datum: " .date("d-m-y", strtotime($e->event_date)). " Event: " .$e->event_name; ?></option>
      <?php } ?>
    </select>
    <input type="submit" name="getdata" class="btn btn-msilo btn-top-space" value="Laad Evenement Data">
      </form>
</section>
<section id="datacheck" class=" container datacheck">
</section>
<section id="container tempdata"></section>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>	
<script src="js/main.js"></script>	
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

 