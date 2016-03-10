# Aaplus changelog

## release/v1.3.0

* AAPLUS-367: Bugfixes
  + Fix af bygnings create bug, fix af klimeskræm calculate bug
  + Fixed reference error between bygning and user. Fixed wrong template being used when bygningtilknytraxadgiver didn’t validate
* AAPLUS-376: Flueben for tilvalgte detailtiltag skal flyttes
* AAPLUS-419: For vinduer og klimaskærm skal der tilføjes i deres priskatalog
* AAPLUS-421, AAPLUS-448: Stjerner skal revurderes
* AAPLUS-422: Tilføjelse af visning for genopretning og modernisering
  + Fixed permissions to edit Løbetid på lån. 
  + Removed block checkbox_row that destroyed proper naming
* AAPLUS-424, AAPLUS-447: Belysningstiltaget ændringer i opsætning
* AAPLUS-425, AAPLUS-446: Ændring af stamdata/bygningsdata
* AAPLUS-426, AAPLUS-445: Ændring af risikovurdering på alle tiltag
* AAPLUS-427, AAPLUS-443: Indføring af CO2-beregning
  NB! The co2y2009 has to be filled out in the forsyningsvaerk table, for the calculations to take effect.
* AAPLUS-433: Bilag kan ikke uploades som rådgiver
* AAPLUS-434: Ændring af farver i likviditetsoverblik
* AAPLUS-449: Tilvælg/fravalg på rapportniveau
* AAPLUS-450: Rediger rapport: ”Faktor” sættes til 1 som Aa+, vises efterfølgende som 0,01 når rådgiver ser den!!!
  NB! Could not be reproduced.
  + Fixed number format bug in Rapport edit forms
* SUPPORT-527: Aa+ / Indtastningsfelter mangler på Specialtiltag
* Bugfix: Calculation for investeringInklFaellesomkostninger corrected
* Cleaned up legacy BygningStatus code
* Fixed issues reported by Scrutinizer

## 2016-01-18 v1.1.0

* Fixed scroll in TiltagDetail table and added fixed table headers
* Updated calculation of "Levetid" in Vinduestiltag
* Removed input field "Levetid" from Vinduestiltag form
* Updated Symphony to version 2.7.9
