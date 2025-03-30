<section class="container-fluid">
    <div class="row">
        <div class="col-sm-<?= ($this->solution->getTitle() != '') ? '8' : '12' ?> mb-3 mb-sm-0">
            <div class="card bg-main-info-exc">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-8 mb-3">
                            <?php if ($this->type == 'error') : ?>
                                <h5 class="card-title error-color font-error badge rounded-pill text-bg-danger"><?= $this->getError() ?></h5>
                            <?php elseif ($this->type == 'exception') : ?>
                                <h5 class="card-title error-color font-error badge rounded-pill text-bg-danger"><?= $this->info_error_exception['type_exception'] ?></h5>
                                <small class="text-secondary"><?= $this->info_error_exception['namespace_exception'] ?? "" ?></small>
                            <?php endif; ?>
                        </div>
                        <div class="col-sm-4 d-flex justify-content-end">
                            <a href="https://stackoverflow.com/search?q=php+<?= strtolower(str_replace(" ", "+", $this->info_error_exception['message'])) ?>" target="_blank">
                                <img src="https://cdn.sstatic.net/Sites/stackoverflow/Img/favicon.ico?v=ec617d715196" title="Search in StackOverflow">
                            </a>
                        </div>
                    </div>

                    <p class="card-text fw-semibold txt-dark-theme">
                        <?php 

                        $message = $this->info_error_exception['message'] ?? "";
                        
                        if (
                            str_contains($message, '{') && 
                            str_contains($message, '}')
                        ) {
                            $message = str_replace(['{', '}'], ['<i>', '</i>'], $message);
                        }

                        echo $message;

                        ?>
                    </p>
                </div>
            </div>
        </div>

        <?php $this->solution = new ModernPHPException\Solution(); ?>

        <?php if ($this->solution->getTitle() != '') : ?>
            <div class="col-sm-4">
                <div class="card bg-solution">
                    <div class="card-body">
                        <h5 class="card-title txt-dark-theme"><?= $this->solution->getTitle() ?></h5>

                        <?php if (!empty($this->solution->getDescription()) || $this->solution->getDescription() != "") : ?>
                            <p class="card-text txt-dark-theme"><?= $this->solution->getDescription() ?></p>
                        <?php endif; ?>

                        <?php if (!empty($this->solution->getDocs()['link']) || $this->solution->getDocs()['link'] != "") : ?>
                            <a target="_blank" href="<?= $this->solution->getDocs()['link'] ?>" class="btn btn-solution">
                                <?= $this->solution->getDocs()['button'] ?>
                            </a>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>