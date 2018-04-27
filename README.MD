# Enquête PHP (symfony 4)

Ce projet a été réaliser


## Installation

### En premier temps 

- vous avez besoin de composer d'installer sur votre machine. Si vous ne l'avez pas, 
allez sur https://getcomposer.org/doc/00-intro.md pour le télécharger et le mettre en place.

### Puis :

Après avoir obtenu composer, ouvrez un terminal et dirigez-vous vers la ou vous avez sauvegarder le dossier

````
> cd C:/.../.../Enquete_PHP/    
````

Puis veuillez rentrer cette commande : 

````
> composer install
````

Si vous ne possédez pas la base donnée lié au projet faite 

````
>  php bin/console doctrine:database:create
>  php bin/console doctrine:schema:update --force
````

sinon installer la base de donnée fournis dans le dossier 
et mettez le sur votre serveur ou phpMyAdmin.

### Afin de lancer le projet 

Vous devez lancer le server symfony : 

````
> php bin/console server:run
````

~ Maxime Bruchet