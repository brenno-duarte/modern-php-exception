<div class="accordion" id="accordionServer">
    <div class="accordion-item">
        <h2 class="accordion-header" id="inputDetails">
            <button class="accordion-button collapsed bg-info-exc text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInput" aria-expanded="false" aria-controls="collapseInput">
                INPUT DATA
            </button>
        </h2>
        <div id="collapseInput" class="accordion-collapse collapse" aria-labelledby="inputDetails" data-bs-parent="#accordionServer">
            <div class="accordion-body">
                <p><strong>GET:</strong></p>
                <?php foreach ($_GET as $key => $value) : ?>
                    <p>
                    <pre><?= "[" . $key . "]" . " => " . $value ?></pre>
                    </p>
                    <hr>
                <?php endforeach; ?>

                <p><strong>POST:</strong></p>
                <?php foreach ($_POST as $key => $value) : ?>
                    <p>
                    <pre><?= "[" . $key . "]" . " => " . $value ?></pre>
                    </p>
                    <hr>
                <?php endforeach; ?>

                <p><strong>COOKIE:</strong></p>
                <?php foreach ($_COOKIE as $key => $value) : ?>
                    <p>
                    <pre><?= "[" . $key . "]" . " => " . $value ?></pre>
                    </p>
                    <hr>
                <?php endforeach; ?>

                <p><strong>FILES:</strong></p>
                <?php foreach ($_FILES as $key => $value) : ?>
                    <p>
                    <pre><?= "[" . $key . "]" . " => " . $value ?></pre>
                    </p>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="serverDetails">
            <button class="accordion-button collapsed bg-info-exc text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseServer" aria-expanded="false" aria-controls="collapseServer">
                SERVER INFORMATION
            </button>
        </h2>
        <div id="collapseServer" class="accordion-collapse collapse" aria-labelledby="serverDetails" data-bs-parent="#accordionServer">
            <div class="accordion-body">
                <?php foreach ($this->indicesServer as $value) : ?>
                    <?php if (isset($_SERVER[$value])) : ?>
                        <p>
                        <pre><?= "[" . $value . "]" . " => " . $_SERVER[$value] ?></pre>
                        </p>
                        <hr>
                    <?php else : ?>
                        <p>
                        <pre><?= "[" . $value . "]" . " => " ?><span class="text-secondary">EMPTY</span></pre>
                        </p>
                        <hr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="aboutDetails">
            <button class="accordion-button collapsed bg-info-exc text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAbout" aria-expanded="false" aria-controls="collapseAbout">
                ABOUT SERVER
            </button>
        </h2>
        <div id="collapseAbout" class="accordion-collapse collapse" aria-labelledby="aboutDetails" data-bs-parent="#accordionServer">
            <div class="accordion-body">
                <p>
                <pre><?= "[PHP_VERSION]" . " => " . phpversion() ?></pre>
                </p>
                <hr>
                <p>
                <pre><?= "[OS]" . " => " . php_uname() ?></pre>
                </p>
                <hr>
                <p>
                <pre><?= "[PEAR_INSTALL_DIR]" . " => " . PEAR_INSTALL_DIR ?></pre>
                </p>
                <hr>
                <p>
                <pre><?= "[PEAR_EXTENSION_DIR ]" . " => " . PEAR_EXTENSION_DIR ?></pre>
                </p>
                <hr>
                <p>
                <pre><?= "[PHP_EXTENSION_DIR ]" . " => " . PHP_EXTENSION_DIR ?></pre>
                </p>
                <hr>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="extDetails">
            <button class="accordion-button collapsed bg-info-exc text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExt" aria-expanded="false" aria-controls="collapseExt">
                LOADED EXTENSIONS
            </button>
        </h2>
        <div id="collapseExt" class="accordion-collapse collapse" aria-labelledby="extDetails" data-bs-parent="#accordionServer">
            <div class="accordion-body">
                <?php foreach (get_loaded_extensions() as $value) : ?>
                    <?= "[" . $value . "]" ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>