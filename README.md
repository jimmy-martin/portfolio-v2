# portfolio-v2

## Voici la seconde version de mon portfolio
Liste des principaux changements apportés par cette version :
- utilisation de Symfony et de Twig pour la partie front de l'application
- un back-office permettant de gérer mon site comme je le souhaite (exemple: CRUD sur les projets, ajout d'un projet sur la page d'accueil, etc.)

## Schéma des données

<img src="docs/Portfolio/Portfolio.svg">

## Modèle conceptuel de données

```
SOFTWARE : software code, name
USES3, 0N USER, 0N SOFTWARE
OPERATING SYSTEM : operating system code, name
:

USES, 0N USER, 0N SKILL
USER : user code, username, firstname, lastname, age, profil, email, github, twitter, linkedin, password, presentation, image
USES2, 0N USER, 0N OPERATING SYSTEM
CATEGORY : category code, name, description

SKILL : skill code, name
MADE BY, 11 PROJECT, 0N USER
PROJECT : project code, title, summary, description, github, url, image
BELONGS TO, 1N PROJECT, 0N CATEGORY
```

## Modèle logique de données

```
SOFTWARE ( software code, name )
USES ( user code, software code )
OPERATING SYSTEM ( operating system code, name )
USES ( user code, skill code )
USER ( user code, username, firstname, lastname, age, profil, email, github, twitter, linkedin, password, presentation, image )
USES ( user code, operating system code )
CATEGORY ( category code, name, description )
SKILL ( skill code, name )
PROJECT ( project code, title, summary, description, github, url, image, user code )
BELONGS TO ( project code, category code )
```
