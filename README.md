# MODX Social Media
![Poi version](https://img.shields.io/badge/version-2.0.0-red.svg) ![MODX Extra by Sterc](https://img.shields.io/badge/checked%20by-Oetzie-blue.svg) ![MODX version requirements](https://img.shields.io/badge/modx%20version%20requirement-2.4%2B-brightgreen.svg)

## Snippets

**Voorbeeld snippet call:**

```
{'!SocialMedia' | snippet : [
    'usePdoTools'   => true,
    'tpl'           => '@FILE elements/chunks/item.chunk.tpl',
    'tplWrapper'    => '@FILE elements/chunks/wrapper.chunk.tpl'
]}
```

**Beschikbare parameters:**

| Parameter                  | Omschrijving                                                                 |
|----------------------------|------------------------------------------------------------------------------|
| criteria | De ID van de criteria waarvan de social media berichten getoond dienen te worden. Meerdere ID's scheiden met een komma. Indien leeg worden gewoon alle criteria getoond. Standaard is leeg. |
| where | De where statement waar de social media berichten aan moeten voldoen. Standaard is `{"active": "1"}`. |
| sortby | De sortby statement waarop de social media berichten gestorteerd moeten worden. Standaard is `{"created": "DESC"}`. |
| limit | Het aantal social media berichten wat getoond mag worden. |
| tpl | De template van een social media bericht. Dit kan een chunknaam, `@FILE` of `@INLINE` zijn. |
| tplWrapper | De template van de wrapper van de social media berichten. Dit kan een chunknaam, `@FILE` of `@INLINE` zijn. |
| tpls | Een JSON object met de templates voor een specifiek social media bericht type. Bijvoorbeeld `{"facebook": "facebookChunk", "twitter": "twitterChunk"}`. |
| usePdoTools | Indien `true` dan word pdoTools gebruikt voor de tpl's en is fenom mogelijk (ook `@FILE` en `@INLINE` zijn mogelijk zonder pdoTools). Standaard `false`. |
| usePdoElementsPath | Indien `true` dan worden `@FILE` tpl's gebruikt vanuit de map die in de `pdotools_elements_path` systeem instelling ingesteld is. Anders word het de `core/components/socialmedia/` map gebruikt. Standaard `false`. |

## Cronjob

De social media berichten worden met behulp van een cronjob gesynchroniseerd, het beste is om deze cronjoh elke uur te runnen.

De cronjob bevindt zich in `assets/components/socialmedia/crobjobs/socialmedia.cronjob.php` en moet aangeroepen worden met een `hash` parameter. Deze parameter moet het zelfde zijn als de `socialmedia.cronjob_hash` system setting. Dit om te voorkomen dat `hackers` of dergelijke onbeperkt de cronjob kunnen aanroepen.

**Voorbeeld cronjob:**

```
php socialmedia.cronjob_hash --hash=modx5bb37a381b64d2.44295829
```

## Access tokens

De meeste API's maken gebruik van oAuth inlog en spreekt wel voor zich. De access tokens hiervan kunnen gegenereerd worden via https://bitbucket.org/sterc/oauthprovider. 

**Instagram**

Voor instagram moet je gebruik maken van de https://instagram.pixelunion.net/ in combinatie met de volgende keys:

- `socialmedia.source_instagram_client_id` -> 386f3c5c7edb4a43b56d0734da552c78
- `socialmedia.source_instagram_client_secret` -> cf8fa82b36fe4bbf8c05b11a857652f3

## Nieuw in 2.0.0

Sinds 2.0.0 word er gebruik gemaakt van criteria, deze criteria bepaald welke social media berichten worden gesynchroniseerd in de cronjob. Voorheen gingen deze 'criteria' aan de hand van systeem instellingen. De nieuwe manier van criteria kan nu bepaald worden binnen het component. Indien je de juiste rechten hebt (`socialmedia_admin`) dan heb je rechts boven in een knop `Admin weergave`.
In deze `Admin weergave` kun je de criteria instellen per social media kanaal. Momenteel word `Twitter`, `Pinterest`, `Youtube`, `Facebook`, `Instagram` (voor hoe lang nog?) en `LinkedIn` ondersteund.

Een criteria kan uit bepaalde delen bestaan, een `@` of een `#`. De @ verwijst naar een gebruiker en een # naar een zoekterm. Niet alle social media API's ondersteunen deze criteria, soms kun je alleen de berichten van het gemachtigde account opgehaald worden (bijvoorbeeld Instagram). Voor sommige social media API\'s (Youtube) kun je bij voor @ een gebruikersnaam of ID invullen. Om hier onderscheid in te maken kun je dit definieren als `@ID:` of `@USERNAME:`.

**Voorbeeld criteria**

```
@meneer.de.bruin
@sterc
@127284723
@ID:127284723
@USERNAME:meneer.de.bruin
#zoeken
#sterc
@me
@self
```

`@me` en `@self` zijn gereserveerde criteria en verwijst naar het account waarmee de API gemachtigd is.