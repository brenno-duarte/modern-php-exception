<?php if ($this->type == 'error') : ?>

    <section>
        <a href="#" onclick="show('<?= $this->getPathInfo($this->info_error_exception['file']) ?>')" class="list-group-item list-group-item-action dark-trace" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                    <?= pathinfo($this->info_error_exception['file'])['basename'] ?>: <span class="badge bg-trace"><?= $this->info_error_exception['line'] ?></span>
                </h5>
            </div>

            <p class="mb-1 label-trace"><?= $this->info_error_exception['file'] ?></p>
        </a>
    </section>

<?php elseif ($this->type == 'exception') : ?>

    <section>
        <a href="#" onclick="show('<?= $this->getPathInfo($this->info_error_exception['file']) ?>')" class="list-group-item list-group-item-action dark-trace" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                    <?= pathinfo($this->info_error_exception['file'])['basename'] ?>: <span class="badge bg-trace"><?= $this->info_error_exception['line'] ?></span>
                </h5>
            </div>

            <p class="mb-1 label-trace"><?= $this->info_error_exception['file'] ?></p>
        </a>

        <?php if (!empty($this->trace)) : ?>

            <div class="accordion accordion-flush" id="accordionFlushExample">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <?= count($this->trace) ?> other error(s)
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">

                        <?php foreach ($this->trace as $trace) : ?>
                            <a href="#" onclick="show('<?= $this->getPathInfo($trace['file']) ?>')" class="list-group-item list-group-item-action dark-trace" aria-current="true">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">
                                        <?= pathinfo($trace['file'])['basename'] ?>: <span class="badge bg-trace"><?= $trace['line'] ?></span>
                                    </h5>
                                </div>

                                <p class="mb-1 label-trace"><?= $trace['file'] ?></p>
                            </a>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>

        <?php endif; ?>

    </section>
<?php endif; ?>