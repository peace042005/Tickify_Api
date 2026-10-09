# Tickify — API et administration

API REST de **Tickify**, application de billetterie d'événements (projet ENEAM 2025). Elle sert l'application mobile [Tickify (Flutter)](https://github.com/peace042005/Tickify) et propose un espace web d'administration pour gérer les événements.

> **Démo :** _lien à ajouter après le déploiement_
> - Application (Flutter web) : `/app/` — compte de test `demo@tickify.test` / `password`
> - Administration : `/login` — compte `admin@tickify.test` / `password`
>
> L'hébergement gratuit met l'application en veille : le premier chargement peut prendre environ une minute.

Documentation de l'API : [Postman](https://documenter.getpostman.com/view/41012504/2sAYX6qNVW)

## Points d'accès (`/api/v1`)

| Méthode | Route | Rôle | Authentification |
|---|---|---|---|
| POST | `/register` | Créer un compte, renvoie un jeton | — |
| POST | `/login` | Se connecter, renvoie un jeton (401 si identifiants incorrects) | — |
| POST | `/logout` | Révoquer les jetons | Bearer |
| GET | `/evenements` | Liste des événements (`?includeType=true` pour les types de billets) | — |
| GET | `/evenements/{id}` | Détail d'un événement | — |
| GET | `/tickets` | Billets de l'utilisateur connecté | Bearer |
| POST | `/tickets` | Acheter un billet (`type_ticket_id`) — refusé si l'événement est complet ou terminé | Bearer |
| GET | `/tickets/{id}` | Détail d'un billet (uniquement le sien) | Bearer |
| DELETE | `/tickets/{id}` | Annuler un billet (uniquement le sien) | Bearer |

## Technologies

Laravel 10, Sanctum (jetons d'API), Eloquent, Blade + Tailwind (administration), SQLite/MySQL, Docker, Render.

## Installation en local

```bash
git clone https://github.com/peace042005/Tickify_Api.git
cd Tickify_Api
composer install && npm install
cp .env.example .env
php artisan key:generate
# Base SQLite : DB_CONNECTION=sqlite dans .env, puis créer database/database.sqlite
php artisan migrate --seed      # rôles, comptes et événements de démonstration
php artisan storage:link
npm run build
php artisan serve
```

## Déploiement (Render)

Le `Dockerfile` construit en une seule image :
1. l'application Flutter en version web (récupérée depuis le dépôt [Tickify](https://github.com/peace042005/Tickify)), servie sur `/app/` ;
2. l'API et l'administration Laravel.

L'application web appelle l'API sur le même domaine : aucune configuration d'URL n'est nécessaire. Sur Render : **New → Blueprint**, puis choisir ce dépôt.

## Équipe

Projet réalisé en équipe de quatre à l'ENEAM (2025) : Léonel Tchassou (auteur principal de l'API — [dépôt original](https://gitlab.com/leonel.tchassou/tickify-api)), Ayila Koukpolou, Isaac Togbe et Marcella Chanhoun.

**Ma contribution (Marcella Chanhoun) :** côté application, la fonctionnalité « Mes billets » ; côté API, la reprise du projet : correction de l'accès à l'administration, des droits sur les billets et de la connexion, contrôle des places disponibles, données de démonstration, conteneurisation et mise en ligne.
