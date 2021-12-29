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
        <?php 
            if(isset($_POST)){
               echo "<pre>"; print_r($_POST); echo"</pre>";
            
                $insertevent = DB::getInstance()->insert("events", array(
                    'eventname' => $_POST['eventname'],
                    'eventdata' => $_POST['eventdate'],
                    'barlead' => $_POST['barleader']
                ));
            }
        ?>
        <nav class="navlist">
            <ul>
                <li><a href="index.php">Begintelling</a></li>
                <li><a href="update.php">Eindtelling</a></li>
                <li><a href="export.php">Export voorraad</a></li>
                <li></li>
                <li></li>
            </ul>
        </nav>
        <form action="<?php $_SERVER["PHP_SELF"];?>" method="post">
        <div class="listgrid">
            <div class="event-header"><h2>Date: </h2><input type="date" name="datum"></div>
            <div class="event-header grid-col-span-2"><h2>Event: </h2><input type="text" name="eventname"></div>
            <div class="event-header grid-col-span-2"><h2>Barhoofd: </h2><input type="text" name="barleader"></div>
            <div class="event-header grid-col-span-2"><h2>Bar: </h2><?php=selectbars(); ?></div>
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
                echo getbeverages();
                
            ?>
       
            <!-- einde data output tabel -->
       </div>         
       <div class="save-data">
           <input type="submit" value="Opslaan">
           <!-- on submit data wegschrijven naar database-->
       </div>
    </form>
    </header>
</body>
</html>
