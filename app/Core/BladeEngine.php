<?php

namespace App\Core;

use Illuminate\View\Factory;
use Illuminate\View\FileViewFinder;
use Illuminate\View\Engines\PhpEngine;
use Illuminate\View\Engines\CompilerEngine;
use Illuminate\View\Engines\EngineResolver;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Events\Dispatcher;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Container\Container;

class BladeEngine
{
    protected $factory;
    protected $container;

    public function __construct()
    {
        $this->container = new Container();
        $filesystem = new Filesystem();

        $viewPaths = [__DIR__ . '/../views'];
        $cachePath = __DIR__ . '/../../cache/views';

        if (!file_exists($cachePath)) {
            mkdir($cachePath, 0755, true);
        }

        $resolver = new EngineResolver();
        $resolver->register('blade', function () use ($filesystem, $cachePath) {
            $compiler = new BladeCompiler($filesystem, $cachePath);
            return new CompilerEngine($compiler);
        });

        $resolver->register('php', function () {
            return new PhpEngine();
        });

        $finder = new FileViewFinder($filesystem, $viewPaths);
        $dispatcher = new Dispatcher($this->container);

        $this->factory = new Factory($resolver, $finder, $dispatcher);
        $this->factory->setContainer($this->container);

        $this->factory->share('errors', $_SESSION['error'] ?? null);
        $this->factory->share('success', $_SESSION['success'] ?? null);
        $this->factory->share('old', $_SESSION['old'] ?? []);
        $this->factory->share('csrf_token', $_SESSION['csrf_token'] ?? '');
        $this->factory->share('user', [
            'id' => $_SESSION['user_id'] ?? null,
            'username' => $_SESSION['username'] ?? null,
            'role' => $_SESSION['user_role'] ?? null,
            'full_name' => $_SESSION['full_name'] ?? null,
        ]);

        unset($_SESSION['error']);
        unset($_SESSION['success']);
        unset($_SESSION['old']);
    }

    public function render($template, $data = [])
    {
        return $this->factory->make($template, $data)->render();
    }
}


