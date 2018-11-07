LDC (ligne de commande) : Récupérer sur GitHub le projet dans un répertoire

git clone git://github.com/jeanfab123/contact.git

Installer NodeJS

    https://nodejs.org/

Installer Composer

    https://getcomposer.org/download/

Installer PHP 7.2.4 et MySQL

    Si Windows

        Installer WAMPSERVER 3.0.6 ou supérieur : https://sourceforge.net/projects/wampserver/files/

        Rajouter dans le Path : C:\wamp64\bin\php\php7.2.4

    Lancer WAMPSERVER (pour MySQL)

Si Linux

    Débrouillez-vous pour avoir PHP en ligne de commande et un serveur MySQL qui tourne :) !

LDC : dans le répertoire du projet, "Updater" Symfony

    composer update

LDC : Installer Doctrine (si la commande précédente ne l'a pas déjà fait)

    composer require symfony/orm-pack
    composer require symfony/maker-bundle --dev
    
Editeur : Modifier le fichier /.env

    DATABASE_URL=mysql://login:pass@server:port/contact

    (remplacer login, pass et port par ceux de votre config MySQL)

LDC : Création de la BDD

    php bin/console doctrine:database:create

LDC : Migration de la BDD

    php bin/console make:migration
    php bin/console doctrine:migrations:migrate

LDC : Lancement du serveur

    php bin/console server:run localhost:8000

Tester le site

    http://localhost:8000/

LDC : Installer Encore (pour JS et CSS)

    composer require encore

Installer Yarn :

    https://yarnpkg.com/

LDC : Installer Yarn pour le projet :

    yarn install

LDC : Installer le loader SASS

    yarn add sass-loader node-sass --dev

    (bien vérifier que le fichier /.gitignore contienne la ligne "/public/build/")

LDC : lancer le watcher SASS

    yarn run encore dev --watch

    (à chaque compilation, il créera les fichiers /public/build/css/style.css et /public/build/js/js.js)

LDC : pour lancer les tests unitaires

    php bin/phpunit tests/Service/TestEmailTest.php