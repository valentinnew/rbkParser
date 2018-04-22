<style>
    .news-list {
        margin: 20px auto 0;
        width: 600px;
    }
</style>
<div class="news-list">
    <?php foreach ($data['news'] as $news): ?>
        <h3><?=$news->title?></h3>
        <div>
            <?= nl2br($news->description) ?>... <a href="?page=news&id=<?=$news->id?>">Подробнее</a>
        </div>
    <?php endforeach ?>
</div>