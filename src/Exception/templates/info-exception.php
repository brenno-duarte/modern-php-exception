<?php if ($this->type == 'exception') : ?>
    <section class="hidden" id="<?= pathinfo($this->info_exception['file'])['filename'] ?>">

        <?php if ($this->info_exception['message']) : ?>
            <div class="row mb-3">
                <div class="col-md-6">
                    <h3><?= $this->info_exception['message'] ?></h3>
                </div>

                <div class="col-md-6 d-flex flex-row-reverse bd-highlight">
                    <a href="https://stackoverflow.com/search?q=php+<?= strtolower(str_replace(" ", "+", $this->info_exception['message'])) ?>" target="_blank">
                        <img src="https://cdn.sstatic.net/Sites/stackoverflow/Img/favicon.ico?v=ec617d715196" title="Search in StackOverflow">
                    </a>
                </div>
            </div>
        <?php endif; ?>

        <pre><code class="language-php code-exception <?= pathinfo($this->info_exception['file'])['filename'] ?>"><?= htmlentities(file_get_contents($this->info_exception['file'])) ?></code></pre>

        <div class="accordion" id="accordionExample">
            <div class="accordion-item">
                <h2 class="accordion-header" id="errorDetails">
                    <button class="accordion-button bg-info-exc text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseError" aria-expanded="true" aria-controls="collapseError">
                        EXCEPTION INFO
                    </button>
                </h2>
                <div id="collapseError" class="accordion-collapse collapse show" aria-labelledby="errorDetails" data-bs-parent="#accordionExample">
                    <div class="accordion-body">
                        <?php if ($this->info_exception['message']) : ?>
                            <p><strong>Message:</strong> <?= $this->info_exception['message'] ?></p>
                        <?php endif; ?>

                        <p><strong>File:</strong> <?= $this->info_exception['file'] ?></p>
                        <p><strong>Line:</strong> <?= $this->info_exception['line'] ?></p>

                        <?php if ($this->info_exception['code']) : ?>
                            <p><strong>Code:</strong> <?= $this->info_exception['code'] ?></p>
                        <?php endif; ?>

                        <!-- <p><strong>Previous Exception:</strong> ?= $exception->getPrevious() ?></p> -->
                        <p><strong>HTTP Code:</strong> <?= http_response_code() ?></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php endif; ?>