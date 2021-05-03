<div class="accordion" id="accordionServer">
    <div class="accordion-item">
        <h2 class="accordion-header" id="inputDetails">
            <button class="accordion-button collapsed bg-info-exc" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInput" aria-expanded="false" aria-controls="collapseInput">
                INPUT DATA
            </button>
        </h2>
        <div id="collapseInput" class="accordion-collapse collapse" aria-labelledby="inputDetails" data-bs-parent="#accordionServer">
            <div class="accordion-body">
                <p><strong>GET:</strong></p>
                <?php foreach ($_GET as $key => $value) : ?>
                    <p>
                    <pre class="txt-dark-theme-2"><?= "[" . $key . "]" . " => " . $value ?></pre>
                    </p>
                    <hr>
                <?php endforeach; ?>

                <p><strong>POST:</strong></p>
                <?php foreach ($_POST as $key => $value) : ?>
                    <p>
                    <pre class="txt-dark-theme-2"><?= "[" . $key . "]" . " => " . $value ?></pre>
                    </p>
                    <hr>
                <?php endforeach; ?>

                <p><strong>COOKIE:</strong></p>
                <?php foreach ($_COOKIE as $key => $value) : ?>
                    <p>
                    <pre class="txt-dark-theme-2"><?= "[" . $key . "]" . " => " . $value ?></pre>
                    </p>
                    <hr>
                <?php endforeach; ?>

                <p><strong>FILES:</strong></p>
                <?php foreach ($_FILES as $key => $value) : ?>
                    <p>
                    <pre class="txt-dark-theme-2"><?= "[" . $key . "]" . " => " . $value ?></pre>
                    </p>
                    <hr>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="serverDetails">
            <button class="accordion-button collapsed bg-info-exc" type="button" data-bs-toggle="collapse" data-bs-target="#collapseServer" aria-expanded="false" aria-controls="collapseServer">
                SERVER INFORMATION
            </button>
        </h2>
        <div id="collapseServer" class="accordion-collapse collapse" aria-labelledby="serverDetails" data-bs-parent="#accordionServer">
            <div class="accordion-body">
                <?php foreach ($this->indicesServer as $value) : ?>
                    <?php if (isset($_SERVER[$value])) : ?>
                        <p>
                        <pre class="txt-dark-theme-2"><?= "<strong>[" . $value . "]</strong>" . " => " . $_SERVER[$value] ?></pre>
                        </p>
                        <hr>
                    <?php else : ?>
                        <p>
                        <pre class="txt-dark-theme-2"><?= "<strong>[" . $value . "]</strong>" . " => " ?><span class="text-empty">EMPTY</span></pre>
                        </p>
                        <hr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="aboutDetails">
            <button class="accordion-button collapsed bg-info-exc" type="button" data-bs-toggle="collapse" data-bs-target="#collapseAbout" aria-expanded="false" aria-controls="collapseAbout">
                ABOUT SERVER
            </button>
        </h2>
        <div id="collapseAbout" class="accordion-collapse collapse" aria-labelledby="aboutDetails" data-bs-parent="#accordionServer">
            <div class="accordion-body">
                <p>
                <pre class="txt-dark-theme-2"><?= "<strong>[PHP_VERSION]</strong>" . " => " . phpversion() ?></pre>
                </p>
                <hr>
                <p>
                <pre class="txt-dark-theme-2"><?= "<strong>[OS]</strong>" . " => " . php_uname() ?></pre>
                </p>
                <hr>
                <p>
                <pre class="txt-dark-theme-2"><?= "<strong>[PEAR_INSTALL_DIR]</strong>" . " => " . PEAR_INSTALL_DIR ?></pre>
                </p>
                <hr>
                <p>
                <pre class="txt-dark-theme-2"><?= "<strong>[PEAR_EXTENSION_DIR ]</strong>" . " => " . PEAR_EXTENSION_DIR ?></pre>
                </p>
                <hr>
                <p>
                <pre class="txt-dark-theme-2"><?= "<strong>[PHP_EXTENSION_DIR ]</strong>" . " => " . PHP_EXTENSION_DIR ?></pre>
                </p>
                <hr>
            </div>
        </div>
    </div>

    <div class="accordion-item">
        <h2 class="accordion-header" id="extDetails">
            <button class="accordion-button collapsed bg-info-exc" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExt" aria-expanded="false" aria-controls="collapseExt">
                LOADED EXTENSIONS
            </button>
        </h2>
        <div id="collapseExt" class="accordion-collapse collapse" aria-labelledby="extDetails" data-bs-parent="#accordionServer">
            <div class="accordion-body">
                <?php foreach (get_loaded_extensions() as $value) : ?>
                    <code><?= "[" . $value . "]" ?></code>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>