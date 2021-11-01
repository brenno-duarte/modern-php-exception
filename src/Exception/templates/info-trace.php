<p class="bg-info-exc">Click on the files below to view the exception</p>
<?php if ($this->type == 'error') : ?>
    <section class="code-exception">
        <?php foreach ($this->info_exception as $info) : ?>
            <a href="#" onclick="show('<?= strtolower(pathinfo($info['file'])['filename'] . str_replace(['#', '{', '}', '(', ')'], '', $info['function'])) ?>')" class="list-group-item list-group-item-action dark-trace" aria-current="true">
                <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-1">
                        <?= pathinfo($info['file'])['basename'] ?>: <span class="badge bg-trace"><?= $info['line'] ?></span>
                    </h5>
                </div>

                <p class="mb-1 text-primary"><?= $info['function'] ?>()</p>
            </a>
        <?php endforeach; ?>
    </section>
<?php elseif ($this->type == 'exception') : ?>
    <section class="code-exception">
        <a href="#" class="list-group-item list-group-item-action dark-trace" aria-current="true">
            <div class="d-flex w-100 justify-content-between">
                <h5 class="mb-1">
                    <?= pathinfo($this->info_exception['file'])['basename'] ?>: <span class="badge bg-trace"><?= $this->info_exception['line'] ?></span>
                </h5>
            </div>

            <p class="mb-1 txt-dark-theme"><?= $this->info_exception['file'] ?></p>
        </a>
    </section>
<?php endif; ?>