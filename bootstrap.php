<?php
declare(strict_types=1);

use Course\Controller\ItemController;
use Course\Http\Application;
use Course\Http\Request;
use Course\Http\Response;
use Course\Http\Router;
use Course\Repository\PdoItemRepository;

return static function (array $variant, PDO $pdo): Application {
    $router = new Router();
    $repository = new PdoItemRepository($pdo);
    // P04-COMPOSITION: Создать контроллер с зависимостями и зарегистрировать пять маршрутов.
    $controller = new ItemController($repository, $variant['categories']);
    $router->add('GET', '/', static fn(Request $request): Response => $controller->listing($request));
    $router->add('GET', '/items', static fn(Request $request): Response => $controller->listing($request));
    $router->add('GET', '/items/new', static fn(Request $request): Response => $controller->newForm());
    $router->add('GET', '/items/{id}', static fn(Request $request, int $id): Response => $controller->show($id));
    $router->add('POST', '/items', static fn(Request $request): Response => $controller->create($request));
    return new Application($router);
};
