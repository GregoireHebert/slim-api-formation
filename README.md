# Tester

Tester c'est douter. 
Douter c'est bien !
Ça permet d'éviter des oublis.

Avant même de lancer des tests, parfois coûteux en CI, on peut déja se protéger avec de l'analyse statique.

```shell
composer require friendsofphp/php-cs-fixer --dev
composer require phpstan/phpstan --dev
```

J'ai ajouté à la racine, 2 fichiers de configuration.

Lancer la correction syntaxique pour visualiser les problèmes : 

```shell
vendor/bin/php-cs-fixer fix --dry-run --diff
```

Puis corrigez-les. Vérifiez toujours avant de les commiter.

```shell
vendor/bin/php-cs-fixer fix
```

Ensuite regardez l'analyse statique : 

```shell
vendor/bin/phpstan analyse
```

Essayer d'en corriger le plus possible.
Notez, que vous êtes au niveau 5. Que je vous recommande le niveau 6 au minimum, et qu'il existe 10 niveaux d'exigence.

## Etape suivante :

Aller sur la branche `phpunit`
