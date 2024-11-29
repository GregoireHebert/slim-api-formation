# Api

A présent nous avons à réaliser les étapes nécessaires au bon fonctionnement d'une API.

## GET

- Authentifier l'utilisateur (401, 404)
- Si l'URL contient des placeholders, les extraire et les transformer au format attendu (uuid, integer, datetime, etc)
- Extraire le nécessaire pour la négociation de contenu (406)
- Extraire les paramètres de filtre, 
- Valider les paramètres de filtre (type, existence, expressions métier, etc.) (422)
- L'utilisateur a-t-il accès à cette opération ? (ACL) (403, 404)
- Aller chercher la ressource cible d'après l'URL (404, 410)
- Sérialiser la resource dans le format attendu par la négociation de contenu

## POST

- Authentifier l'utilisateur (401, 404)
- Si l'URL contient des placeholders, les extraire et les transformer au format attendu (uuid, integer, datetime, etc)
- Extraire le nécessaire pour la négociation de contenu (406)
- L'utilisateur a-t-il accès à cette opération ? (ACL) (403, 404)
- Aller chercher la ressource cible d'après l'URL (404, 410)
- Extraire le body de la requête (POST, PUT, PATCH)
- Valider le body (type, existence, expressions métier) (422)
- Désérialiser le body en l'objet resource
- Si c'est une sous ressource, nourrir la ressource parente.
- L'utilisateur a-t-il accès à cette opération ? (ACL) (403, 404)
- Donner la ressource ou ressource parente à un processor (pour stockage, ou procédure)
- Sérialiser la resource dans le format attendu par la négociation de contenu
  En cas de création

## PUT, PATCH

- Authentifier l'utilisateur (401, 404)
- Si l'URL contient des placeholders, les extraire et les transformer au format attendu (uuid, integer, datetime, etc)
- Extraire le nécessaire pour la négociation de contenu (406)
- L'utilisateur a-t-il accès à cette opération ? (ACL) (403, 404)
- Aller chercher la ressource cible d'après l'URL (404, 410)
- Extraire le body de la requête (POST, PUT, PATCH)
- Valider le body (type, existence, expressions métier) (422)
- Désérialiser le body et écraser les valeurs de la ressource
- L'utilisateur a-t-il accès à cette opération ? (ACL) (403, 404)
- Donner la ressource à un processor (pour stockage, ou procédure)
- Sérialiser la resource dans le format attendu par la négociation de contenu

## DELETE

- Authentifier l'utilisateur (401, 404)
- Si l'URL contient des placeholders, les extraire et les transformer au format attendu (uuid, integer, datetime, etc)
- Extraire le nécessaire pour la négociation de contenu (406)
- L'utilisateur a-t-il accès à cette opération ? (ACL) (403, 404)
- Aller chercher la ressource cible d'après l'URL (404, 410)
- Donner la ressource à un processor (pour suppression)
- Retourner une 204

## Mise en place

Pour gagner du temps, j'ai pris la liberté d'utiliser quelques librairies et de mettre en place un mécanisme de découverte des classes pour accélérer nos développements.

- les Uid de Symfony pour la génération d'UUID
- Le Parser PHP de Nikic pour enregistrer les classes automatiquement comme service
- Les Metadata de API Platform (déclaration des ressources et opérations)
- Les States de API Platform (Délégation des opérations)
- Le mapper de Jolicode

Voici ce que nous avons : 

Dans le répertoire `src`, vous devriez retrouver une structure qui vous est familière, du MVC !

Les contrôleurs dans `Controller`.
Les modèles dans le répertoire `ApiResources`, ainsi que leur endpoint.
Les vues... ne sont pas nécessaire dans une API, on se contentera de serialiser.

Chaque endpoint fait référence à un provider et/ou un processor. 
L'un pour récupérer des données, l'autre pour les manipuler.

Les provider et processors sont dans le répertoire `State`.
Leur rôle est celui d'un médiator ou d'un orchestrateur. 
Il connait la logique métier à appliquer, les services à appeler.

En l'occurrence, Ils vont chercher un repository capable d'aller lire et écrire les données des personnes.
Leur implémentation se trouve dans le répertoire `Repository`.

Je récapitule. 

On déclare une resource `Person`, qui délègue les appels à la logique métier aux processors et providers selon le type d'opération. Qui à leur tour délèguent les véritables opérations de lecture/écriture au repository.

Avec un `PUT` pour modifier une valeur, mon processor obtient directement l'objet mis à jour.

Pour que tout ceci fonctionne, j'ai écrit un peu de code dans le répertoire Infrastructure et dans la configuration du container, mais ne vous en préoccupez pas pour le moment.

## Exercice 1

Ajouter une propriété `verlant` à la personne.
Créer un service dont le rôle est de prendre le nom de la personne, inverser les caractères et la stocker dans la propriété.

## Exercice 2

Créer un Middleware qui rejette toutes les requêtes dont l'entête `accept` n'est pas `application/json`
Associer ce Middleware aux routes de l'API.

## Exercice 3

Modifier le routing d'API pour utiliser un groupe de route.
https://www.slimframework.com/docs/v4/objects/routing.html#route-groups

--

Avant d'aller plus loin décryptons ensemble le code de la configuration du container ainsi que du répertoire `Infrastructure`. 

## Etape suivante :

Aller sur la branche `tester`
