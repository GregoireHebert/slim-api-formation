# Structurer son code

Pour avoir un code perenne, il faut appliquer la séparation des responsabilités.

Voici un exemple de découpage simple. 

Le routeur Slim reçoit une requête HTTP et la transmet à une action/controller.
L'action/controller forme les données pour le domaine à partir de la requete, puis appelle le code du domaine.
Le domaine s'occupe de la validation et logique métier, de lire et stocker les données.
L'action appelle un service pour construire ensuite un résultat dans le format attendu par le client
L'action renvoie la réponse HTTP à Slim.

## Le domaine

C'est le bon endroit pour la logique métier, par exemple le calcul, la validation, la gestion des transactions, la création de fichiers, etc. La logique métier est plus complexe que juste des opérations CRUD (Create, Read, Update and Delete). 

On les déclare sous forme de service.

## Domaine et infrastructure

L'infrastructure (slim) n'appartient pas à l'application principale. Elle agit comme un système externe qui communique avec votre application, par exemple la base de données, l'envoi de mail, etc.

Un service d'infrastructure peut être

- des implémentations pour les repository par exemple
- les contrôleurs web (actions), la console, etc.
- Code spécifique au framework

En séparant le code du domaine de celui de l'infrastructure, vous augmentez automatiquement la testabilité. En prime, vous pouvez remplacer une implémentation sans affecter les utilisateurs.

Au sein de la couche Domaine, vous disposez de plusieurs autres types de classes, par exemple :

- les services avec la logique métier, c'est-à-dire les cas d'utilisation
- les value objects, les DTO, les entités, c'est-à-dire le modèle interne
- Les interfaces des repository

## Lire

* [The Clean Architecture](https://blog.cleancoder.com/uncle-bob/2012/08/13/the-clean-architecture.html)
* [The Onion Architecture](https://jeffreypalermo.com/2008/07/the-onion-architecture-part-1/)
* [Action Domain Responder](https://github.com/pmjones/adr)
* [Domain-Driven Design](https://amzn.to/3cNq2jV) (The blue book)
* [Implementing Domain-Driven Design](https://amzn.to/2zrGrMm) (The red book)
* [Hexagonal Architecture](https://fideloper.com/hexagonal-architecture)
* [Alistair in the Hexagone](https://www.youtube.com/watch?v=th4AgBcrEHA)
* [Hexagonal Architecture demystified](https://madewithlove.be/hexagonal-architecture-demystified/)
* [Functional architecture](https://www.youtube.com/watch?v=US8QG9I1XW0&t=33m14s) (Video)
* [Object Design Style Guide](https://www.manning.com/books/object-design-style-guide?a_aid=object-design&a_bid=4e089b42)
* [Advanced Web Application Architecture](https://leanpub.com/web-application-architecture/) (Book)
* [Advanced Web Application Architecture](https://www.slideshare.net/matthiasnoback/advanced-web-application-architecture-full-stack-europe-2019) (Slides)
* [The Beauty of Single Action Controllers](https://driesvints.com/blog/the-beauty-of-single-action-controllers)
* [On structuring PHP projects](https://www.nikolaposa.in.rs/blog/2017/01/16/on-structuring-php-projects/)
* [Standard PHP package skeleton](https://github.com/php-pds/skeleton)
* [Services vs Objects](https://dontpaniclabs.com/blog/post/2017/10/12/services-vs-objects)
* [Stop returning arrays, use objects instead](https://www.brandonsavage.net/stop-returning-arrays-use-objects-instead/)
* [Data Transfer Objects - What Are DTOs](https://www.youtube.com/watch?v=35QmeoPLPOQ)
* [SOLID](https://www.digitalocean.com/community/conceptual_articles/s-o-l-i-d-the-first-five-principles-of-object-oriented-design)

## Etape suivante :

Aller sur la branche `api`
