<ul class="list-group list-group-numbered">
    <div class="accordion accordion-flush">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
                <div class="accordion-button collapsed bg-light main-error txt-dark-theme">
                    Main Error
                </div>
            </h2>
        </div>
    </div>

    <li class="border-0 list-group-item d-flex justify-content-between align-items-start">
        <a class="text-secondary" href="#" style="text-decoration: none; cursor: pointer;" onclick="show('<?= $this->getPathInfo($this->info_error_exception['file']) ?>')">
            <div class="ms-2 me-auto">
                <div class="fw-bold txt-dark-theme"><?= pathinfo($this->info_error_exception['file'])['basename'] ?></div>

                <small class="text-primary txt-error-file"><?= (!empty($this->info_error_exception['namespace_exception'])) ? $this->info_error_exception['namespace_exception'] : $this->info_error_exception['file'] ?></small>
            </div>
        </a>

        <span class="badge bg-danger rounded-pill error-color">
            <?= $this->info_error_exception['line'] ?>
        </span>
    </li>

    <?php if ($this->type === 'exception') : ?>
        <?php if (!empty($this->trace)) : ?>

            <div class="accordion accordion-flush" id="accordion-trace">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="flush-headingOne">
                        <button class="txt-dark-theme accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                            <?= count($this->trace) ?> other error(s)
                        </button>
                    </h2>
                    <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordion-trace">

                        <?php foreach ($this->trace as $trace) : ?>
                            <li class="list-group-item d-flex justify-content-between align-items-start">
                                <a class="text-secondary" href="#" style="text-decoration: none;" onclick="show('<?= $this->getPathInfo($trace['file']) ?>')">
                                    <div class="ms-2 me-auto">
                                        <div class="fw-bold txt-dark-theme"><?= pathinfo($trace['file'])['basename'] ?></div>

                                        <small class="text-primary txt-error-file"><?= $trace['file'] ?></small>
                                    </div>
                                </a>

                                <span class="badge bg-danger rounded-pill error-color">
                                    <?= $trace['line'] ?>
                                </span>
                            </li>
                        <?php endforeach; ?>

                    </div>
                </div>
            </div>

        <?php endif; ?>
    <?php endif; ?>
</ul>