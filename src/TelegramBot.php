<?php

namespace Tii\Telepath;

use Cache\Bridge\SimpleCache\SimpleCacheBridge;
use League\Container\Container;
use League\Container\ReflectionContainer;
use Psr\Cache\CacheItemPoolInterface;
use Psr\SimpleCache\CacheInterface;
use Tii\Telepath\Conversations\Conversation;
use Tii\Telepath\Handlers\ConversationHandler;
use Tii\Telepath\Handlers\Handler;
use Tii\Telepath\Layers\Generated;
use Tii\Telepath\Middleware\Middleware;
use Tii\Telepath\Telegram\Update;

class TelegramBot extends Generated
{
    public ?string $username = null;

    public readonly Container $container;

    protected array $middleware = [];

    /** @var Handler[] */
    protected array $handlers = [];

    public function __construct(string $botToken, string $baseUri = 'https://api.telegram.org')
    {
        parent::__construct($botToken, $baseUri);

        $this->container = new Container();
        $this->container->delegate(new ReflectionContainer());
        $this->container->addShared(TelegramBot::class, $this);
        $this->container->addShared(Update::class, fn() => new Update());
    }

    public function discoverPsr4(string $path): static
    {
        $files = new \RegexIterator(
            new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($path)),
            '/.*\.php/'
        );

        /** @var \SplFileInfo $file */
        foreach ($files as $file) {

            $namespace = $this->getNamespace($file->getRealPath());
            $class = $namespace . '\\' . $file->getBasename('.php');

            foreach ((new \ReflectionClass($class))->getMethods(\ReflectionMethod::IS_PUBLIC) as $method) {

                $attributes = $method->getAttributes();

                foreach ($attributes as $attribute) {

                    if (! is_subclass_of($attribute->getName(), Handler::class)) {
                        continue;
                    }

                    $this->handlers[] = $attribute->newInstance()
                        ->assign($class, $method->getName());

                }

            }

        }

        return $this;
    }

    public function enableCaching(CacheInterface|CacheItemPoolInterface $cache): static
    {
        if ($cache instanceof CacheItemPoolInterface) {
            $cache = new SimpleCacheBridge($cache);
        }

        if ($this->container->has(CacheInterface::class)) {
            $this->container->extend(CacheInterface::class)->setConcrete($cache);
        } else {
            $this->container->addShared(CacheInterface::class, $cache);
        }

        return $this;
    }

    public function handleWebhook(): bool
    {
        $this->identifyUsername();

        $input = file_get_contents('php://input');

        if (empty($input)) {
            return false;
        }

        $json = json_decode($input, true);

        if ($json === null) {
            return false;
        }

        $update = new Update($json);

        $this->processUpdate($update);

        return true;
    }

    public function handlePolling(): never
    {
        $this->identifyUsername();

        $offset = 0;
        while (true) {

            $updates = $this->getUpdates(offset: $offset, timeout: 60);

            foreach ($updates as $update) {

                $offset = max($offset, $update->update_id + 1);
                $this->processUpdate($update);

            }

        }
    }

    public function middleware(array|Middleware|string $middleware): static
    {
        if (! is_array($middleware)) {
            $middleware = [$middleware];
        }

        $this->middleware = array_merge($this->middleware, $middleware);

        return $this;
    }

    /**
     * @return Middleware[]
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    protected function identifyUsername()
    {
        if ($this->username !== null) {
            return;
        }

        $me = $this->getMe();
        $this->username = $me->username;
    }

    protected function getAvailableConversationHandler(Update $update): ?ConversationHandler
    {
        if (! $this->container->has(CacheInterface::class)) {
            return null;
        }

        $cache = $this->container->get(CacheInterface::class);
        $json = $cache->get(Conversation::cacheKey($update));
        if ($json === null) {
            // Nothing in Cache
            return null;
        }

        $data = json_decode($json, true);
        if ($data === null) {
            // Invalid JSON
            return null;
        }

        [$class, $method] = $data['next'];

        if (! class_exists($class)) {
            // Class does not exist
            return null;
        }

        $conversation = $this->container->get($class);
        $conversation->fill($data);

        return (new ConversationHandler())
            ->assign($conversation, $method);
    }

    protected function processUpdate(Update $update): mixed
    {
        $this->container->extend(Update::class)->setConcrete($update);

        $responsibleHandlers = [];

        $conversationHandler = $this->getAvailableConversationHandler($update);
        if ($conversationHandler) {
            $responsibleHandlers[] = $conversationHandler;
        }

        $responsibleHandlers = array_merge(
            $responsibleHandlers,
            array_filter($this->handlers, fn(Handler $handler) => $handler->responsible($this, $update))
        );

        if (count($responsibleHandlers) === 0) {
            return null;
        }

        // TODO: Sort handlers by priority

        $handler = reset($responsibleHandlers);
        return $handler->dispatch($this, $update);
    }

    private function getNamespace(string $file): ?string
    {
        $tokens = token_get_all(file_get_contents($file));

        $namespace = '';
        $namespaceKeyword = false;
        foreach ($tokens as $token) {
            if (is_array($token) && $token[0] === T_NAMESPACE) {
                $namespaceKeyword = true;
            } elseif ($namespaceKeyword && ! is_array($token) && $token === ';') {
                break;
            } elseif ($namespaceKeyword) {
                $namespace .= is_array($token) ? $token[1] : $token;
            }
        }

        $namespace = trim($namespace);

        return $namespace ?: null;
    }

}
