<?php
require_once ROOT_DIR . '/lib/simple_html_dom.php';

class Parser
{
    public function parseNewsList($html, $limit = 1)
    {
        $dom = str_get_html($html);
        $newsBlocks = $dom->find('div.news-feed__list');

        if (!isset($newsBlocks[0])) {
            return [];
        }
        $newsBlock = $newsBlocks[0];
        $news = $newsBlock->find('a.news-feed__item');

        $urls = [];
        foreach ($news as $newsItem) {
            list($srcUrl,) = explode('?', $newsItem->href);
            $urls[] = $srcUrl;
            if (count($urls) >= $limit) {
                break;
            }
        }

        return $urls;
    }

    public function parseNews($html)
    {
        $dom = str_get_html($html);
        $articles = $dom->find('div.article__fix-width');

        if (!isset($articles[0])) {
            return false;
        }
        $article = array_shift($articles);
        return [
            'created' => $this->parseDate($article),
            'title'   => $this->parseTitle($article),
            'img'     => $this->parseImg($article),
            'text'    => $this->parseText($article),
        ];
    }

    private function parseDate($article)
    {
        $timeBlocks = $article->find('span.article__header__date');
        $strTime = trim(array_shift($timeBlocks)->plaintext);
        $exploded = explode(',', $strTime);
        if (count($exploded) === 1) {
            // only time. Today
            list($hour, $minute) = explode(':', $exploded[0]);
            $time = strtotime('today') + $hour * 3600 + $minute * 60 - 3 * 3600;
        } elseif (count($exploded) === 2) {
            // date and time
            list($day, $month) = explode(' ', trim($exploded[0]));
            $monthMap = ['янв'=>'01','фев'=>'02','мар'=>'03','апр'=>'04','май'=>'05','июня'=>'06','июля'=>'07','авг'=>'08','сен'=>'09','окт'=>'10','ноя'=>'11','дек'=>'12'];

            $str = date('Y') . '-' . $monthMap[trim($month)] . '-' . trim($day). $exploded[1] . ':00+03';
            $time = strtotime($str);
        } else {
            // не добрался до новостей других годов
            $time = time();
        }
        return $time;
    }

    private function parseTitle($article)
    {
        $titles = $article->find('span.js-slide-title');
        $title = trim(array_shift($titles)->plaintext);
        return $title;
    }

    private function parseImg($article)
    {
        $imgs = $article->find('img.article__main-image__image');

        $img = '';
        if (count($imgs) > 0) {
            $img = $imgs[0]->src;
        }
        return $img;
    }

    private function parseText($article)
    {
        $textBlocks = $article->find('div.article__text');
        $textBlock = array_shift($textBlocks);

        $filters = [
            'div.article__picture',
            'div.article__clear',
            'div.twitter-tweet',
            'script',
            'div.banner',
            'div.article__inline-material',
            'div.article__photoreport'
        ];

        foreach ($filters as $filter) {
            $filteredElements = $textBlock->find($filter);
            foreach ($filteredElements as $filteredElement) {
                $filteredElement->outertext = '';
            }
        }

        $links = $textBlock->find('a');
        foreach ($links as $link) {
            $link->outertext = $link->innertext;
        }

        $nls = $textBlock->find('p');
        $lines = [];
        foreach ($nls as $nl) {
            $lines[] = $nl->innertext;
        }
        $text = implode("\n", $lines);
        return $text;
    }
}