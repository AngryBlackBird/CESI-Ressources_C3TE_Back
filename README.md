
# Ressources CESI CDA 

Comment installer le projet



## Requierements

- [Docker desktop (Utilisation de docker compose)](https://www.docker.com/products/docker-desktop/)

## Tech Stack

**Techno:** Symfony 6.4

**Server:** apache, php 8.2, mariadb, maildev


## Installation 

Download repository 


```bash 
git clone https://github.com/AngryBlackBird/Ressources_C3TE_Back.git
```

Dans votre projet, entrez dans le dossier `.docker.dev` puis lancez votre installation Docker.
```bash
docker-compose build --no-cache
docker-compose up -d
```

Après l'installation terminée, au sein du dossier `.docker.dev`, lancez la commande pour entrer dans le conteneur PHP.
```bash 
docker-compose exec php bash
```

Dans votre conteneur PHP, installez les dépendances de l'application.

```bash 
composer install
php bin/console doctrine:migration:migrate 
php bin/console doctrine:fixture:load 
```

Allez dans votre navigateur et accédez à http://ressource.localhost/api.

Le projet est installé.

## Liens utiles 

- Projet : `http://ressource.localhost/api`
- ProjetHttps : `https://ressource.localhost:443/api`
- PhpMyAdmin : `http://ressource.localhost:81`
- MailDev : `http://ressource.localhost:1080`
