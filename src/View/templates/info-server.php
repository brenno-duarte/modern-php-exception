<!-- Server -->
<section class="hidden bg-main-info-exc rounded-3 p-3" id="servervariablesid">

    <h6 class="txt-dark-theme">About Server</h6>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <span class="bg-info-exc">Operating System: </span>
            <span class="txt-dark-theme"><?= php_uname('s') ?></span>
        </li>
        <li class="list-group-item">
            <span class="bg-info-exc">Machine Type: </span>
            <span class="txt-dark-theme"><?= php_uname('m') ?></span>
        </li>
        <li class="list-group-item">
            <span class="bg-info-exc">Host Name: </span>
            <span class="txt-dark-theme"><?= php_uname('n') ?></span>
        </li>
        <li class="list-group-item">
            <span class="bg-info-exc">Release Name: </span>
            <span class="txt-dark-theme"><?= php_uname('r') ?></span>
        </li>
        <li class="list-group-item">
            <span class="bg-info-exc">Version Information: </span>
            <span class="txt-dark-theme"><?= php_uname('v') ?></span>
        </li>
    </ul>

    <h6 class="mt-3 txt-dark-theme">About PHP</h6>
    <ul class="list-group list-group-flush">
        <li class="list-group-item">
            <span class="bg-info-exc">PHP Version: </span>
            <span class="txt-dark-theme"><?= PHP_VERSION ?></span>
        </li>
        <li class="list-group-item">
            <span class="bg-info-exc">OS family PHP was built: </span>
            <span class="txt-dark-theme"><?= PHP_OS ?></span>
        </li>
        <li class="list-group-item">
            <span class="bg-info-exc">PHP extension directory: </span>
            <span class="txt-dark-theme"><?= PHP_EXTENSION_DIR ?></span>
        </li>
    </ul>
</section>

<!-- Extensions -->
<section class="hidden bg-main-info-exc rounded-3 p-3" id="extensionsvariablesid">

    <?php

    $values = get_loaded_extensions();
    natsort($values);

    ?>

    <h6 class="txt-dark-theme">PHP Extensions enabled</h6>
    <ul class="list-group list-group-flush">
        <?php foreach ($values as $value) : ?>
            <li class="list-group-item bg-info-exc"><?= $value ?></li>
        <?php endforeach; ?>
    </ul>
</section>