# portfolio-v2

## Voici la deuxième version de mon portfolio avec toujours le même template mais cette fois-ci avec le framework Symfony et une réelle base de données

## Schéma des données

<img src="docs/Portfolio/Portfolio.svg">

## Modèle conceptuel de données

```
CATEGORY : category code, name, description
BELONGS TO1, 1N POST, 0N CATEGORY
POST : post code, title, content
HAS2, 0N POST, 11 COMMENT
COMMENT : comment code, author, content

BELONGS TO, 1N PROJECT, 0N CATEGORY
PROJECT : project code, title, summary, description, github, demonstration
MADE BY, 11 PROJECT, 0N USER

SKILL : skill code, name
HAS, 0N USER, 0N SKILL
USER : user code, firstname, lastname, age, profil, email, github, twitter, linkedin
```

## Modèle logique de données

```
CATEGORY ( category code, name, description )
BELONGS TO ( post code, category code )
POST ( post code, title, content )
COMMENT ( comment code, author, content, post code )
BELONGS TO ( project code, category code )
PROJECT ( project code, title, summary, description, github, demonstration, user code )
SKILL ( skill code, name )
HAS ( user code, skill code )
USER ( user code, firstname, lastname, age, profil, email, github, twitter, linkedin )
```
