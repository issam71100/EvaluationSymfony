# Getting started

## Installation

Please check the official symfony installation guide for server requirements before you start. [Official Documentation](https://symfony.com/doc/current/setup.html)


**Clone the repository**

    git clone git@github.com:issam71100/EvaluationSymfony.git

Or 

    git clone https://github.com/issam71100/EvaluationSymfony.git
    
**Switch to the repo folder**

    cd EvaluationSymfony

**Install PHP dependencies using composer**

    composer install
    
**Install node dependencies using yarn or nmp**

    yarn install

Or

    npm install

**Generate Webpack Assets**

    yarn build

Or

    npm run build

**Run the database migrations (*Set the database connection in .env before migrating*)**

    php bin/console doctrine:migrations:migrate
 

**Generate Fixtures**

    php bin/console doctrine:fixtures:load


**Start the local development server**

    php bin/console server:run

***You can now access the server at http://localhost:8000***


# Front de Application

**Homepage ( route => '/' )**

* Diaporama de 9 images des 3 dernieres oeuvres de chaques catégories 
* 3 Dernieres oeuvres ajoutés de chaques catégories

**Page Oeuvre (route => '/artworks)**

* Liste de toute les oeuvres d'arts
* Filtre par catégorie en ajax

**Page Oeuvre (route => '/artwork/{slug})**

* Détail d'une oeuvre
* Image de l'oeuvre en backround + titre par dessus
* Description de l'oeuvre
* Image entière de l'oeuvre

**Pages Categories (route => '/artworks/{slug})**

* Liste de toute les oeuvres d'arts appartenant à la catégorie lié au slug

**Pages Exposition (route => '/expositions)**

* Liste de toute les futures expositions avec pour image celle de la première oeuvre. Si elle ne contiens pas d'oeuvre, une image par defaut est affiché

**Pages Exposition (route => '/exposition/{slug})**

* Présentation de l'exposition
* Liste des oeuvres d'arts présenté

**Pages Contact (route => '/contact)**

* Formulaire de contact
* Changer le fichier config/packages/dev/swiftmailer.yaml afin de recevoir le mail


# Backoffice de Application  (route => '/admin/*)


**Index Oeuvres (route => '/admin/artwork)**

* List des oeuvre + information
* posibilité de voir, modifier ou supprimer une oeuvre

**Page Single Oeuvre (route => '/admin/artwork/{id})**

* Informations d'une oeuvre
* Possibilité de supprimer ou modifier une l'oeuvre
* Lien de retour vers la lite

**Page création d'une Oeuvre (route => '/admin/artwork/new)**

* Formulaire de création d'une oeuvre
* Champs Image affiche l'image chargé en js
* Champs obligatoire => name, description, country, image, category
* Formulaire imbriqué (Entité Place) 

**Page mofification d'une Oeuvre (route => '/admin/artwork/update/{id})**

* Formulaire de modification
* Champs Image affiche l'image chargé en js

**Route suppression d'une Oeuvre (route => '/admin/artwork/delete/{id})**

* Accessible seulement avec la method http DELETE
* Supprime une oeuvre


# 


**Index Categories (route => '/admin/category)**

* List des categories + information
* posibilité de voir, modifier ou supprimer une Categories

**Page Single Categories (route => '/admin/category/{id})**

* Informations d'une Categories
* Possibilité de supprimer ou modifier une Categories
* Lien de retour vers la liste des Categories

**Page création d'une Categories (route => '/admin/category/new)**

* Formulaire de création d'une Categories
* Champs obligatoire => name

**Page mofification d'une Categories (route => '/admin/category/update/{id})**

* Formulaire de modification

**Route suppression d'une Categories (route => '/admin/category/delete/{id})**

* Accessible seulement avec la method http DELETE
* Supprime une Categorie

# 

**Index Expositons (route => '/admin/category)**

* List des expositons + information
* posibilité de voir, modifier ou supprimer une expositon

**Page Single Expositon (route => '/admin/expositon/{id})**

* Informations d'une Expositon
* Possibilité de supprimer ou modifier une expositon
* Liste des oeuvres de l'exposition
* Lien de retour vers la liste des expositons

**Page création d'une Expositon (route => '/admin/expositon/new)**

* Formulaire de création d'une expositon
* Champs obligatoire => name, description, date, country, artworks

**Page mofification d'une Expositon (route => '/admin/expositon/update/{id})**

* Formulaire de modification

* Route suppression d'une Expositon (route => '/admin/expositon/delete/{id})

* Accessible seulement avec la method http DELETE
* Supprime une Categorie