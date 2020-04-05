<div class="card" style="width: 18rem;">
    <img class="card-img-top" src="<?= $this->image ?>" alt="<?= $this->alt ?>">
    <div class="card-body">
        <h5 class="card-title"><?= $this->title ?></h5>
        <p class="card-text"><?= $this->text ?></p>
        <?php $this->content() ?>
    </div>
</div>
