Changelog
=========

Version 1.1.2 – 07.09.2017
--------------------------

### Bugfixes

* Der Abruf von Instagram-Tags (ohne Access-Token) schlug auf 32-Bit-Systemen fehl


Version 1.1.1 – 07.09.2017
--------------------------

### Bugfixes

* Der Abruf über die inoffizielle Instragram-Schnittstelle (ohne Access-Token) funktionierte nicht mehr. 
  ACHTUNG: Beim Abruf eines Users-Feeds muss nun der Benutzername statt der Benutzer-ID hinterlegt werden


Version 1.1.0 – 15.05.2017
--------------------------

### Neu

- Youtube-Unterstützung
- Instagram-Unterstützung
- Bei Twitter wird auch das Bild ausgelesen, falls vorhanden
- Media-Manager-Effekt zur Auslieferung (und Weiterbearbeitung) der Bilder über den Media Manager

### Bugfixes

- Cronjob für Script-Umgebung korrigiert
- URL-Feld enthielt uneinheitliche Werte, nun immer die URL des Originalbeitrages
- Bei Twitter-Hashtags werden Retweets ignoriert
- Bei Twitter wurde die Original-ID teilweise nicht richtig gespeichert
- Bei Twitter wurden die Texte nicht immer vollständig eingelesen