# Piézométrie - Niveau des nappes phréatiques

## Informations

Appel API

* Documentation : https://api.gouv.fr/documentation/api_hubeau_piezometrie
* Url : https://hubeau.eaufrance.fr


* Récupération des stations actives entre 1990 et aujourd'hui
* Récupération des mesures à partir de 1990
* Attention, certaines stations sont actives après 1990 et ne le sont plus aujourd'hui


## Liste des stations

### Requête

GET /api/v1/niveaux_nappes/stations

* date_recherche sera utilisé

### Réponse

```json
{
  "code_bss": "00387X0184/PZCC1",
  "urn_bss": "http://services.ades.eaufrance.fr/pointeau/00387X0184/PZCC1",
  "date_debut_mesure": "1977-03-24",
  "date_fin_mesure": "2022-09-14",
  "code_commune_insee": "59270",
  "nom_commune": "Grand-Fayt",
  "x": 3.794037727,
  "y": 50.109494526,
  "codes_bdlisa": [
    "149AC03"
  ],
  "urns_bdlisa": [
    "http://reseau.eaufrance.fr/geotraitements/bdlisa/files/entite/149AC03.pdf"
  ],
  "geometry": {
    "type": "Point",
    "crs": {
      "type": "name",
      "properties": {
        "name": "urn:ogc:def:crs:OGC:1.3:CRS84"
      }
    },
    "coordinates": [
      3.79403772731546,
      50.1094945256155
    ]
  },
  "bss_id": "BSS000DQWD",
  "altitude_station": "143.0",
  "nb_mesures_piezo": 7069,
  "code_departement": "59",
  "nom_departement": "Nord",
  "libelle_pe": "Forage du Campiau (Grand Fayt) - 59",
  "profondeur_investigation": 36,
  "codes_masse_eau_edl": [
    "B2G316"
  ],
  "noms_masse_eau_edl": [
    "Calcaires de l'Avesnois"
  ],
  "urns_masse_eau_edl": [
    "http://www.sandre.eaufrance.fr/geo/MasseDEauSouterraine/B2G316"
  ],
  "date_maj": "Tue Mar 03 02:49:38 CET 2020"
}
```

Données filtrables :

* libelle_pe
* nom_commune
* code_departement
* date_debut_mesure
* date_fin_mesure


## Chroniques

### Requête

GET /api/v1/niveaux_nappes/chroniques

* code_bss est obligatoire.
* date_debut_mesure sera utilisé.


### Réponse

```json
{
  "code_bss": "00387X0184/PZCC1",
  "urn_bss": "http://services.ades.eaufrance.fr/pointeau/00387X0184/PZCC1",
  "date_mesure": "2022-09-14",
  "timestamp_mesure": 1663138800000,
  "niveau_nappe_eau": 139.51,
  "mode_obtention": "Valeur mesurée",
  "statut": "Donnée contrôlée niveau 1",
  "qualification": "Correcte",
  "code_continuite": "2",
  "nom_continuite": "Point lié au point précédent",
  "code_producteur": "265",
  "nom_producteur": "Service Géologique Régional Nord - Pas de Calais (265)",
  "code_nature_mesure": null,
  "nom_nature_mesure": null,
  "profondeur_nappe": 4.37
}
```

Données importantes :
* niveau_nappe_eau
* date_mesure et timestamp_mesure

Données filtrables :
* date_mesure et timestamp_mesure
