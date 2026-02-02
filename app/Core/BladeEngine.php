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

        // Correct paths for shared hosting
        $viewPaths = [__DIR__ . '/../views'];
        $cachePath = __DIR__ . '/../../cache/views';

        // Ensure cache directory exists with proper permissions
        if (!file_exists($cachePath)) {
            @mkdir($cachePath, 0755, true);
        }
        
        // Ensure cache directory is writable
        if (!is_writable($cachePath)) {
            @chmod($cachePath, 0755);
        }

        $resolver = new EngineResolver();
        $resolver->register('blade', function () use ($filesystem, $cachePath) {
            $compiler = new BladeCompiler($filesystem, $cachePath);
            
            // Register custom @auth directive
            $compiler->directive('auth', function () {
                return '<?php if(auth()->check()): ?>';
            });
            
            // Register custom @endauth directive
            $compiler->directive('endauth', function () {
                return '<?php endif; ?>';
            });
            
            // Register custom @guest directive
            $compiler->directive('guest', function () {
                return '<?php if(!auth()->check()): ?>';
            });
            
            // Register custom @endguest directive
            $compiler->directive('endguest', function () {
                return '<?php endif; ?>';
            });
            
            return new CompilerEngine($compiler);
        });

        $resolver->register('php', function () use ($filesystem) {
            return new PhpEngine($filesystem);
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

