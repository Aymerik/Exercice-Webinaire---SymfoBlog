# Webinaire | Exercice  1 : SymfoBlog

## Présentation de l'exercice
Afin de partager votre savoir, vous souhaitez développer un mini-blog permettant l’ajout et la lecture d’articles, comprenant trois pages :
* Une page d’accueil, qui liste l’ensemble des articles postés par ordre décroissant. Pour chaque article, son titre, une introduction, la date de publication et l’auteur doivent être affichés.
* Une page post, qui affiche le détail d’un article et qui s’affiche au clic sur l’un des articles en page d’accueil. La page doit afficher l’ensemble des informations d’un article : titre, introduction, contenu, date de publication et auteur.
* Une page de création d’un article : un formulaire comportant les champs titre, introduction, contenu, date de publication et auteur. Les erreurs (champs non remplis ou au mauvais format) doivent être traitées.


Le blog devra être réalisé avec le framework Symfony. Un template Bootstrap comme [Clean Blog](https://startbootstrap.com/themes/clean-blog/) peut être utilisé.

Lors de votre développement, vous utiliserez les librairies et outils suivants :
* Doctrine pour la gestion de la base de données
* Twig pour la gestion des vues
* Le FormBuilder de Symfony
* Le composant Validator
* Vos données seront initialisées avec le DoctrineFixturesBundle (la librairie Faker peut également être utilisée)


## Correction
Ce repository vous présente la correction du projet. Si vous souhaitez installer le projet, voici les étapes à suivre :

1. Clonez ou téléchargez le dépôt
2. Créez un fichier .env.local à la racine du dépôt contenant cette ligne : `DATABASE_URL=mysql://<login>:<password>@127.0.0.1:3306/<db name>?serverVersion=5.7`
3. Dans le dossier du projet, lancez les commandes :
    1. `composer install`
    2. `php bin/console doctrine:database:create` si votre base de données n'existe pas
    3. `php bin/console doctrine:migrations:migrate`
    4. `php bin/console doctrine:fixtures:load`
    5. `symfony server:start`
4. Accédez au site en tapant `http://localhost:8000/`dans votre navigateur

## Aller plus loin ?
La correction contient la gestion des commentaires, la modification et la suppression de posts, ainsi qu'une gestion simplifiée de la pagination.

Pour aller plus loin, vous pouvez mettre en place un espace membre, en vous appuyant sur [la documentation](https://symfony.com/doc/current/security.html).
