<?php
define('ROOT_DIR', __DIR__);

require_once __DIR__ . '/src/Parser.php';
require_once __DIR__ . '/src/NewsModel.php';
require_once __DIR__ . '/src/Repository.php';

$url = 'https://www.rbc.ru';

$mainPage = file_get_contents($url);
$parser = new Parser();
$newsUrls = $parser->parseNewsList($mainPage, 15);
$repository = Repository::getInstance();
foreach ($newsUrls as $newsUrl) {
    $newsHtml = file_get_contents($newsUrl);

    $parsedData = $parser->parseNews($newsHtml);
    if ($parsedData) {
        $parsedData['srcUrl'] = $newsUrl;
        $parsedData['description'] = mb_substr($parsedData['text'], 0, 200);
        $newsModel = new NewsModel($parsedData);

        var_dump($repository->save($newsModel));
        var_dump($newsModel);
    }
}