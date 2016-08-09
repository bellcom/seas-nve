# Aaplus changelog

## v1.6.1
* SUPPORT-679:  Fixed bug on baseline edit and on new rapport/bilag  

## v1.6.0
* AAPLUS-550    Dataudtræk - historisk

## v1.5.0
* AAPLUS-557	Opsplitning af “version"
* AAPLUS-551	"Dato for drift" på Rapport
* AAPLUS-549	Dataudtræk - vælg mellem rapport/tiltag output
* AAPLUS-548	Dataudtræk - vælgmulighed på kollonner
* AAPLUS-544	Baseline
* AAPLUS-542	Fremhæv "aktuel" række efter redigering
* AAPLUS-541	Ret op på labels i dashboard
* AAPLUS-539	Gemme dokument 2 og 5 for hver fase.
* AAPLUS-538	Visning af Scrapværdi, reinvest. og evt. der blev fjernet, kan vises under tiltag/oversigt
* AAPLUS-536	Imp. i udtræk viser ingen værdi.
* AAPLUS-534	Mulighed for at genberegne en rapport ved tryk på en knap
* AAPLUS-532	Når der søges på en rapport, må adresse gerne indgå
* AAPLUS-531	Mulighed for at fjerne ting under lister i indstillinger
* AAPLUS-530	Under vinduer skal "yderligere besparelse" flyttes fra økonomi op under Vindues-området
* AAPLUS-529	Visninger på forsiden af rapporterne ift. liste over tiltag (til- og fravalgt) skal der laves lidt tilføjelser
* AAPLUS-528	På forsiden for Aa+ medarbejderen skal man kunne se status på alle ejendomme.
* AAPLUS-527	Tilføje notesfelt under vinder
* AAPLUS-526	Vinduesberegning skal have tilføjet faktor, "glasandel"
* AAPLUS-525	Pumpelisten (dropdown) skal vises mere
* AAPLUS-524	Der er problem med intern rente
* AAPLUS-522	Opretning af ny brugertype / login
* AAPLUS-521	Listerne for Aa+ som "afleveret rådgiver" og bygningslisten for segmenter skal kun vise de bygnigner som er tilknyttet den givende login.
* AAPLUS-520	Under klimaskærm "Priskategori"-listen er der døre i, disse skal flyttes over i "priskategori"-listen for vinduer.
* AAPLUS-519	Tekst beskæres i siden, så det er ikke muligt at se hvad der står. F.eks. for nutidsværdi kWh-besp.
* AAPLUS-518	Rådgiveren har mulighed for at se hvilken segment bygningen er tilknyttet. Det er i igangværende bygninger overblikket, samt Aa+'er
* AAPLUS-517	Rådgiver kan have mulighed for at justere i tilbagebetaling tid. (Lave analyse)
* AAPLUS-516	Til og fravalg

## v1.4.0
* @TODO

## v1.3.0

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
* SUPPORT-527: Aa+ / Indtastningsfelter mangler på Specialtiltag
* Bugfix: Calculation for investeringInklFaellesomkostninger corrected
* Cleaned up legacy BygningStatus code
* Fixed issues reported by Scrutinizer
* Fixed number format bug in Rapport edit forms

## v1.2.3
* SUPPORT-527: Re-added Missing fields to Specialtiltag edit screen

## v1.2.2
* Issue #AAPLUS-434 by tuj: Changed colours for graphs

## v1.2.1
* Issue #AAPLUS-433 by tuj: Fixed bilag permissions.

## 2016-01-18 v1.1.0

* Fixed scroll in TiltagDetail table and added fixed table headers
* Updated calculation of "Levetid" in Vinduestiltag
* Removed input field "Levetid" from Vinduestiltag form
* Updated Symphony to version 2.7.9
