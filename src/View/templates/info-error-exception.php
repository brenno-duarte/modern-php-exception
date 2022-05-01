<?php if ($this->type == "error") : ?>

    <section class="hidden bg-main-info-exc rounded-3" id="<?= $this->getPathInfo($this->info_error_exception['file']) ?>">
        <pre><code class="language-php code-exception p-3"><?= htmlentities(file_get_contents($this->info_error_exception['file'])) ?></code></pre>
    </section>

<?php elseif ($this->type == "exception") : ?>

    <section class="hidden bg-main-info-exc rounded-3" id="<?= $this->getPathInfo($this->info_error_exception['file']) ?>">
        <pre><code class="language-php code-exception p-3 <?= $this->getPathInfo($this->info_error_exception['file']) ?>"><?= htmlentities(file_get_contents($this->info_error_exception['file'])) ?></code></pre>
    </section>

    <?php foreach ($this->trace as $trace) : ?>

        <section class="hidden bg-main-info-exc rounded-3" id="<?= $this->getPathInfo($trace['file']) ?>">
            <pre><code class="language-php code-exception p-3 <?= $this->getPathInfo($trace['file']) ?>"><?= htmlentities(file_get_contents($trace['file'])) ?></code></pre>
        </section>

    <?php endforeach ?>

<?php endif; ?>