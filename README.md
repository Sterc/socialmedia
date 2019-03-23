# MODX Social Media
![Poi version](https://img.shields.io/badge/version-2.0.0-red.svg) ![MODX Extra by Sterc](https://img.shields.io/badge/checked%20by-Oetzie-blue.svg) ![MODX version requirements](https://img.shields.io/badge/modx%20version%20requirement-2.4%2B-brightgreen.svg)

## Snippets

**Voorbeeld snippet call:**

```
{'!SocialMedia' | snippet : [
    'usePdoTools'   => true,
    'tpl'           => '@FILE elements/chunks/item.chunk.tpl',
    'tplWrapper'    => '@FILE elements/chunks/wrapper.chunk.tpl',
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
| usePdoElementsPath | Indien `true` dan worden `@FILE` tpl's gebruikt vanuit de map die in de `pdotools_elements_path` systeem instelling ingesteld is. Anders word het de `core/components/chatbot/` map gebruikt. Standaard `false`. |
