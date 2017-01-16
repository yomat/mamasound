# Appels AJAX de l'application web

## technos
jquery

## Principe des appels AJAX


## section du site

### I. Sélection de la date courante


### II. Les évévements
 
#### 1. Item _Tout_
- description : les événements du **jour sélectionné**
- route : ` mamasound/events ` <=> ` mamasound/events/all_events `
    ```
    @Route( "/events/{eventType}/{date}", 
                    name="events",
                    defaults={"date":null, "eventType":"all_events"})
    ```
- action : appel AJAX d'obtention des événements du **jour sélectionné**
- triggered by : `on_load()`, `on_click()`

#### 2. Item _Concert_
- description : liste des événements musicaux du **jour sélectionné**
- route : `mamasound/events/concert` 
- action : filtrer les événements musicaux du _jour courant_
- triggered by : `on_click()`

#### 3. Item _Expo_
- description : liste des expositions du **jour sélectionné**
- route : `mamasound/events/expo` 
- action : filtrer les expositions du _jour courant_
- triggered by : `on_click()`

#### 4. Item _Théâtre_
- description : liste des représentations du **jour sélectionné**
- route : `mamasound/events/theatre` 
- action : filtrer les représentations du _jour courant_
- triggered by : `on_click()`


##### III. Détail d'un événement