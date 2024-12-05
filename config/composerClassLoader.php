<?php

use PhpParser\ParserFactory;
use PhpParser\Node;
use PhpParser\NodeTraverser;
use PhpParser\NodeVisitorAbstract;

function getComposerNamespaces($composerJsonPath) {
    $composerData = json_decode(file_get_contents($composerJsonPath), true, 512, JSON_THROW_ON_ERROR);
    $namespaces = [];

    foreach (['autoload', 'autoload-dev'] as $autoloadType) {
        if (isset($composerData[$autoloadType]['psr-4'])) {
            $namespaces = array_merge($namespaces, $composerData[$autoloadType]['psr-4']);
        }
    }

    return $namespaces;
}

function extractFQCNFromFile($filePath) {
    $parser = (new ParserFactory())->createForHostVersion();

    $stmts = $parser->parse(file_get_contents($filePath));

    $visitor = new class() extends NodeVisitorAbstract {
        private array $fqcnList = [];
        private string $namespace;

        public function getFirstClass() {
            return $this->fqcnList[0] ?? null;
        }

        public function enterNode(Node $node) {
            if ($node instanceof Node\Stmt\Namespace_) {
                // Capture the namespace name
                $this->namespace = implode('\\', $node->name->getParts());
            }

            if ($node instanceof Node\Stmt\Class_) {
                // Capture the class name and associate with the namespace
                $className = $node->name->name;
                $this->fqcnList[] = $this->namespace . '\\' . $className;
            }
        }
    };

    // Traverse the AST
    $traverser = new NodeTraverser();
    $traverser->addVisitor($visitor);
    $traverser->traverse($stmts);

    return $visitor->getFirstClass();
}

function getClassesFromFiles($directory) {
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator(PROJECT_ROOT_DIR . '/' . $directory)
    );
    $classes = [];

    foreach ($iterator as $file) {
        if ($file->getExtension() === 'php') {
            $fqcn = extractFQCNFromFile($file->getPathname());
            if ($fqcn) {
                $classes[] = $fqcn;
            }
        }
    }

    return $classes;
}

