<?php require_once 'core/init.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Voorraad lijsten Maassilo</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <div class="listgrid">
            <div class="event-header"><h2>Date: </h2>27-12-2021</div>
            <div class="event-header grid-col-span-3"><h2>Event: </h2>Gezellige Muziekavond</div>
            <div class="event-header grid-col-span-2"><h2>Barhoofd: </h2>Jante Nooitgenoeg</div>
            <div class="event-header grid-col-span-2"><h2>Bar: </h2>Hoofdzaal</div>
            <div class="event-header">Begin Telling</div>
            <div class="event-header">Eind Telling</div>
            <div class="event-header">Opmerkingen</div>
            <div class="event-header">Controle</div>
            <!-- start van data-->
            <!-- query voor drank met eenheid en per drank de voorraad ophalen + eventuele opmerkingen en controle status-->
            <!-- voorbeeld ouptut-->
            <div class="drink-name">Pepsi</div>
            <div class="drink-vol">28x20cl</div>
            <div class="pre-count">2</div>
            <div class="post-count">1</div>
            <div class="remarks">1 fles laten vallen</div>
            <div class="check">Piet Baas</div>
            <!-- voorbeeld output met velden-->
            <?php
                $event = DB::getInstance()->query("SELECT * FROM events ORDER BY ID DESC LIMIT 1");
                if(!$event->count()){
                    echo "html met 0 velden aangezien er geen laatste events zijn";
                } else {
                $stock = DB::getInstance()->get('stock', 'eventid', '=', $event->results()['ID'])
                
                foreach($stock->results() as $inventory) {
                    $beverage = DB::getInstance()->get('beverage', 'beverage_id', '=', $inventory->beverageid);
                    $beverage->results();
                    echo $inventory->precount;
                    echo $inventory->postcount;
                }
                }
            ?>
            <div class="drink-name">Pepsi</div>
            <div class="drink-vol">28x20cl</div>
            <div class="pre-count">
                <input type="text" name="precount" value="<?php $row->precount;?>">
            </div>
            <div class="post-count">
                <input type="text" name="postcount" value="<?php $row->postcount;?>">
            </div>
            <div class="remarks">
                <textarea name="remarks" cols="30" rows="3" value="<?php $row->remarks;?>"></textarea>
            </div>
            <div class="check">
                <input type="text" name="control" value="<?php $row->control;?>"> 
            </div>
            <!-- einde data output tabel -->
       </div>         
       <div class="save-data">
           <input type="submit" value="Opslaan">
           <!-- on submit data wegschrijven naar database-->
       </div>
    </header>
</body>
</html>
