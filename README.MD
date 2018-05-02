# Enquête PHP (symfony 4)

Ce projet a été réalisé


## Installation

### Dans un premier temps 

- vous avez besoin de Composer d'installé sur votre machine. Si vous ne l'avez pas, 
allez sur https://getcomposer.org/doc/00-intro.md pour le télécharger et le mettre en place.

### Puis :

Après avoir obtenu Composer, ouvrez un terminal et dirigez-vous vers là où vous avez sauvegardé le dossier

````
> cd C:/.../.../Enquete_PHP/    
````

Puis veuillez rentrer cette commande : 

````
> composer install
````

Puis mettez en place votre config server dans .env :

Remplacez : 
````
DATABASE_URL='mysql://db_user:db_password@127.0.0.1:3306/db_name'
````

Par: 
````
DATABASE_URL='mysql://root:@127.0.0.1:3306/bd_questionnaire'
````

Si vous ne possédez pas la base de données liée au projet, exécutez : 

````
>  php bin/console doctrine:database:create
>  php bin/console doctrine:schema:update --force
````

sinon installer la base de données fournie dans le dossier 
et mettez le sur votre serveur ou phpMyAdmin.

### Afin de lancer le projet 

Vous devez lancer le server symfony : 

````
> php bin/console server:run
````

## Outils de développement

* [Symfony](https://symfony.com/) - Framework Symfony
* [PHPSTORM] (https://www.jetbrains.com/phpstorm/) - IDE PHP



~ Maxime Bruchet
