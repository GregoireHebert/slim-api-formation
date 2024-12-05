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

Enfin, lancer l'analyse avec l'option (payante) --pro, permet d'apprendre visuellement des erreurs.

## PHP Unit

```shell
composer require --dev phpunit/phpunit
```

PHPunit se configure a la racine du projet avec le fichier `phpunit.xml`.
Dans lequel on va définir un fichier capable de définir l'état de l'application (le fichier `bootstrap.php`)
la configuration de PHP, des variables d'environnement, ainsi que l'emplacement des tests.

C'est un peu plus couteux, mais on peut aussi lui demander de mesurer la couverture de code.

```xml
<?xml version="1.0" encoding="UTF-8"?>
<phpunit xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:noNamespaceSchemaLocation="vendor/phpunit/phpunit/phpunit.xsd"
         backupGlobals="false"
         backupStaticProperties="false"
         bootstrap="tests/bootstrap.php"
         colors="true"
         cacheDirectory=".phpunit.cache">
    <php>
        <ini name="error_reporting" value="-1"/>
        <ini name="memory_limit" value="-1"/>
        <env name="APP_ENV" value="test"/>
        <env name="PHPUNIT_TEST_SUITE" value="1"/>
    </php>
    <coverage />
    <source ignoreSuppressionOfDeprecations="true" ignoreIndirectDeprecations="true" >
        <include>
            <directory suffix=".php">src</directory>
        </include>
        <exclude>
            <directory>public</directory>
            <directory>var</directory>
            <directory>vendor</directory>
        </exclude>
    </source>
    <testsuites>
        <testsuite name="Slim Project Tests">
            <directory>tests</directory>
        </testsuite>
    </testsuites>
</phpunit>
```

Pour s'organiser, le répertoire `tests` doit contenir un reflet du répertoire `src`.

J'ai commencé par créer un test pour m'assurer que bien que j'ai un seul contrôleur d'API, sans une ressource associée,
je ne peux pas l'atteindre, et obtiendrai une 404.

Ce test se trouve dans `tests/Controller/ApiTest.php`
Un test étend TestCase. Chaque cas d'usage possible de la classe testée, devra être testé ici.
De nos méthodes, l'outil n'appellera que les méthodes préfixées de `test...` ou avec l'attribut `Test`, ce qui est plus pratique.
Il regardera aussi l'existence de méthodes spécifiques pour déclencher du code lorsqu'il charge cette classe de tests, 
a la fin de cette classe de tests, avant et après chaque méthode de test, pratique pour préparer des données.


```php
<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class ApiTest extends TestCase
{
    #[Test]
    public function PageNotFound(): void
    {
        // write test
    }
}
```

PhpUnit ne sait pas quel genre de programme nous testons. C'est pourquoi il ne fournit que des méthodes de test très générique.
Les frameworks nous facilitent le travail puisqu'un grand nombre de méthodes dédiées au web et aux API existent dans leurs librairies.
Nous devons le faire de notre côté.

J'ai pris la liberté de coder quelques traits PHP pour ne pas avoir le faire durant notre formation.

Le test que nous avons, est un test fonctionnel. C'est le plus robuste. Il garantit que votre application fonctionne normalement.
Écrivez-en beaucoup. Pour vérifier du contenu ou des valeurs, PHPUnit fourni une batterie de méthodes d'assertion, servez-vous-en.

Nous concevons une API, nous allons devoir écrire une forme de tests fonctionnels que sont les contracts tests.
Nous allons nous assurer que l'API réponde toujours correctement, et en particulier en cas d'erreur.

Ensuite, il faudra écrire des tests end to end, pour nous assurer que notre code a bien fait les appels aux services externes
Emails, queue, api, bdd, etc.

Lorsque nous sommes satisfait, nous pouvons ajouter des tests unitaires pour verrouiller du code complexe et dynamique.
Nous pouvons aussi ajouter du mutation testing pour nous assurer que nos tests sont robustes.
Nous pouvons ajouter des tests architecturaux pour nous assurer que nos règles d'architecture sont respectées.
Et je passe bien d'autres tests, chacun avec des objectifs spécifiques.

## Exercice

Votre exercice est de tester le comportement du nameInverter, et son usage avec l'API.

## Etape suivante :

Aller sur la branche `phpunit-inverter`
