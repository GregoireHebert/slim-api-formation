# Tester

C'est déjà mieux. Passons au niveau 6, et regardons. Et là, encore plus de rigueur sur le typage.
C'est trop de travail immédiat, on corrigera petit à petit.

```shell
vendor/bin/phpstan analyse --generate-baseline
```

Génère un fichier pour arrêter de réclamer de corriger les erreurs déjà connues.
Une extension, permet aussi d'ajouter des TODO pour ne pas oublier : https://github.com/staabm/phpstan-todo-by

En l'important dans la configuration de phpstan les erreurs sont ignorées.

```yaml
includes:
	- phpstan-baseline.neon
```

Lorsque vous les corrigez, PHPstan vous dira de retirer les exclusions.
Il est possible d'ajouter des règles personnalisées, et plusieurs existent.

```shell
composer require --dev phpstan/phpstan-deprecation-rules
composer require --dev phpstan/phpstan-strict-rules
composer require --dev ergebnis/phpstan-rules
```

Note: Au moment de la préparation de la formation, phpstan 2 est sorti, mais toutes les dépendances ne sont pas encore à jour. 
peut-être opter pour phpstan 1.x pour en bénéficier.

## Etape suivante :

Aller sur la branche `phpunit`
