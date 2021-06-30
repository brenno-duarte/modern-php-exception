<?php if ($this->type == 'error') : ?>
    <?php foreach ($this->info_exception as $info) : ?>
        <section class="hidden bg-main-info-exc rounded-3" id="<?= pathinfo($info['file'])['filename'] ?>">

            <?php if ($info['message']) : ?>
                <div class="row mb-3 p-3">
                    <div class="col-md-6">
                        <h3 class="fw-bold"><?= $info['message'] ?></h3>
                    </div>

                    <div class="col-md-6 d-flex flex-row-reverse bd-highlight">
                        <a href="https://stackoverflow.com/search?q=php+<?= strtolower(str_replace(" ", "+", $info['message'])) ?>" target="_blank">
                            <img src="https://cdn.sstatic.net/Sites/stackoverflow/Img/favicon.ico?v=ec617d715196" title="Search in StackOverflow">
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <pre><code class="language-php code-exception p-3 <?= pathinfo($info['file'])['filename'] ?>"><?= htmlentities(file_get_contents($info['file'])) ?></code></pre>

            <div class="accordion accordion-flush" id="accordionError">
                <div class="accordion-item">
                    <h2 class="accordion-header" id="errorDetails">
                        <button class="accordion-button bg-info-exc" type="button" data-bs-toggle="collapse" data-bs-target="#collapseError" aria-expanded="true" aria-controls="collapseError">
                            EXCEPTION INFORMATION
                        </button>
                    </h2>
                    <div id="collapseError" class="accordion-collapse collapse show" aria-labelledby="errorDetails" data-bs-parent="#accordionError">
                        <div class="accordion-body">
                            <?php if ($info['message']) : ?>
                                <p><strong>Message:</strong> <?= $info['message'] ?></p>
                            <?php endif; ?>

                            <hr>
                            <p><strong>File:</strong> <?= $info['file'] ?></p>
                            <hr>
                            <p><strong>Line:</strong> <?= $info['line'] ?></p>
                            <hr>

                            <?php if ($info['code']) : ?>
                                <p><strong>Code:</strong> <?= $info['code'] ?></p>
                            <?php endif; ?>

                            <hr>
                            <p><strong>HTTP Code:</strong> <?= http_response_code() ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endforeach; ?>
<?php endif; ?>