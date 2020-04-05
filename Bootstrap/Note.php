<div class="card" style="width: 18rem;">
    <img class="card-img-top" src="<?= $view->image ?>" alt="<?= $view->alt ?>">
    <div class="card-body">
        <h5 class="card-title"><?= $view->title ?></h5>
        <div class="card-text">
            <?= $view->text  ?>
        </div>
        <?= $view->content ?>
    </div>
</div>