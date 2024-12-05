<?php

include_once 'composerClassLoader.php';

return function (array $exclude = []) {
    $services = [];

    $composerJsonPath = PROJECT_ROOT_DIR . '/composer.json';
    $namespaces = getComposerNamespaces($composerJsonPath);

    foreach ($namespaces as $namespacePrefix => $directory) {
        $classes = getClassesFromFiles($directory);
        foreach (array_filter($classes) as $class) {
            foreach ($exclude as $excludeNamespace) {
                if (str_starts_with($class, $excludeNamespace)) {
                    continue 2;
                }
            }

            $services[$class] = DI\autowire();
        }
    }

    return $services;
};

