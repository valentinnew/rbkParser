<style>
    .news {
        margin: 20px auto 0;
        width: 600px;
    }
</style>
<div class="news">
    <h3><?=$data['news']->title?></h3>
    <?php if (!empty($data['news']->img)): ?>
        <img width="600" src="<?=$data['news']->img?>">
    <?php endif ?>
    <div>
        <?= nl2br($data['news']->text) ?>
    </div>
</div>
