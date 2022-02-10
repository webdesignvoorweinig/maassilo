<?php 
  require_once 'inc/headerinc.php';
?>
      <div class="container-fluid mt-5">
        <div class="row">
          <form id="gevents" class="col-md col-sm-12">
          <div class="row" id="selectevent">
          	<div class="col-6">
            <h2> Selecteer Evenement</h2>
          	</div>
          	<div class="col-6">
            <h2> Selecteer Bar</h2>
          </div>
          <div class="col-lg-6 col-md-12 mb-2">
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
					<option name="eventid" value="<?php echo $e->eventid; ?>"><?php echo "datum: " .date("d-m-y", strtotime($e->event_date)). " event: " .$e->event_name; ?></option>

				<?php } ?>
            </select>
          </div>
          
          <div class="col-lg-6 col-md-12">
          	<?php echo getbars(); ?>
            <input type="submit" name="postevent" class="sbmt btn btn-primary" value="Eind Tellijst">
            <!--<input type="submit" name="postevent" class="sbmt btn btn-success" value="Eind Tellijst">-->
          </div>
          </div>
          </form>
      </div>
    </div>
  </header>
<div id="stock">
</div>
  <div id="tmp"></div>
  
</div>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>	
  <script src="js/main.js"></script>	
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>