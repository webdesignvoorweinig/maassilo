# Voorraadlijst systeem maassilo

Doel is om een webapplicatie te maken waarin de voorraad drank bijgehouden kan worden.
Tellen voor begin avond en tellen aan het einde van de avond. Vervolgens is de nieuwe telling
voor de start van de volgende dag de telling aan het einde van dag ervoor als uitgangspunt.

Bij voorkeur database toevoeging om vanuit daar lijsten te kunnen draaien en emailen.  

Robbertjan gaat mij de voorbeelden in excel mailen zodat ik het format kan zien. 
Aan de hand daarvan een plan van aanpak maken.
Project dient voor einde lockdown gereed te zijn, ga uit van 14 jan op zijn vroegst.
Robbert Jan dacht dat ik dit in 4 uur kon maken maar dat moeten we nog bezien.

## Plan van aanpak

- devserver lokaal aanmaken met docker en vanuit daar werken met db en dergelijke.
- doelsysteem moet php kunnen draaien en de webapplicatie ( Robbert Jan moet dit regelen )

## Database

velden:
    - ID
    - Datum
    - dranken
    - aantal voor
    - aantal na

tabellen:
    - basis ( id, datum_id )
    - dranken ( drank_id, drank_naam )
    - dranken_data ( datum_id, Drank_id, aantal_voor, aantal_na.

bij het lezen van data dan zijn de huidige aantallen de aantal_na van de vorige datum_id,
indien er geen datum_id is dan 0 ( start waarde )

voor het draaien van de lijst en controle op basis van een datum_id.

## Benodigdheden
    - pagina met invul formulier welke bewaard kan worden.
    - script om data te exporteren naar een csv welke in excel bewerkt weer
    kan worden om bestellingen te doen. ( button maken voor de export to csv optie )
    - DB class gebruiken die je eerder hebt geschreven en aanpassne op dit project.
    - moet er een username / password gedeelte in om vast te leggen wie de voorraad heeft gedaan?

