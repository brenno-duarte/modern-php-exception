<!-- Server -->
<section class="hidden bg-main-info-exc rounded-3 p-3" id="servervariablesid">
    <?php foreach ($this->indicesServer as $value) : ?>
        <?php if (isset($_SERVER[$value])) : ?>
            <p>
            <pre class="txt-dark-theme-2"><span class="bg-info-exc"><?= $value ?></span>: <?= $_SERVER[$value] ?></pre>
            </p>
            <hr>
        <?php else : ?>
            <p>
            <pre class="txt-dark-theme-2"><span class="bg-info-exc"><?= $value ?></span>: <span class="text-empty">EMPTY</span></pre>
            </p>
            <hr>
        <?php endif; ?>
    <?php endforeach; ?>

    <p>
    <pre class="txt-dark-theme-2"><span class="bg-info-exc">OS</span>: <?= php_uname() ?></pre>
    </p>
    <hr>
    <p>
    <pre class="txt-dark-theme-2"><span class="bg-info-exc">PEAR_INSTALL_DIR</span>: <?= PEAR_INSTALL_DIR ?></pre>
    </p>
    <hr>
    <p>
    <pre class="txt-dark-theme-2"><span class="bg-info-exc">PEAR_EXTENSION_DIR</span>: <?= PEAR_EXTENSION_DIR ?></pre>
    </p>
    <hr>
    <p>
    <pre class="txt-dark-theme-2"><span class="bg-info-exc">PHP_EXTENSION_DIR</span>: <?= PHP_EXTENSION_DIR ?></pre>
    </p>
</section>

<!-- Extensions -->
<section class="hidden bg-main-info-exc rounded-3 p-3" id="extensionsvariablesid">
    <?php $values = get_loaded_extensions();
    natsort($values); ?>
    
    <?php foreach ($values as $value) : ?>
        <span class="bg-info-exc"><?= "[" . $value . "]" ?></span>
    <?php endforeach; ?>
</section>