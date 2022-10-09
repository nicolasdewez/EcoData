# Incendies de forêts en Europe

## Informations

Appel API

* Documentation : https://effis.jrc.ec.europa.eu
* Url : https://api2.wild-fire.eu


* Récupération des statistiques des pays européens (EU et non EU)
* Données récupérables depuis 2005
* Feux cartographiés d'environ 10ha ou +

* Pays de l'UE : AUT,BEL,BGR,HRV,CYP,CZE,DNK,EST,FIN,FRA,DEU,GRC,HUN,IRL,ITA,LVA,LTU,LUX,MLT,NLD,POL,PRT,ROU,SVK,SVN,ESP,SWE
* Pays européens hors UE : ALB,BIH,GEO,MNE,MKD,NOR,SRB,CHE,TUR,UKR,GBR


## Statistiques Europe

### Requête

GET /statistics/effis/estimatesoverview

* countries sera utilisé (il faut lister les pays que l'on souhaite sinon 500)
* year sera utilisé

### Réponse

```json
{
    "iso3": "AUT",
    "name": "Austria",
    "ba": 1016,
    "nf": 5,
    "ba_avg": 17.375,
    "nf_avg": 0.1875,
    "ba_p": 0.01211568496783785,
    "nf_p": 5.962443389683981e-05,
    "ba_avg_p": 0.00020719490779151837,
    "nf_avg_p": 2.235916271131493e-06,
    "area_ha": 8385823.853104973
}
```

Données filtrables :

* iso3 / name
* year (pas présent dans la réponse)


Données importantes :

* area_ha : superficie du pays (en ha)
* ba : superficie brulée
* nf : nombre de feux
* ba_p : %age de la superficie brulée par rapport à la superficie totale
