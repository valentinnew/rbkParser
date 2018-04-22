<?php
require_once __DIR__ . '/src/Repository.php';
require_once __DIR__ . '/src/Renderer.php';


// микророутинг
if (isset($_REQUEST['page']) && $_REQUEST['page'] === 'news') {
    $action = 'news';
    $id = (int) $_REQUEST['id'];
    echo (new Renderer())->render('layout.php', [
        'content' => (new Renderer())->render('news.php', [
            'news' => Repository::getInstance()->getOne($id),
        ])
    ]);
} else {
    echo (new Renderer())->render('layout.php', [
        'content' => (new Renderer())->render('all-news.php', [
            'news' => Repository::getInstance()->getAll(),
        ])
    ]);
}

