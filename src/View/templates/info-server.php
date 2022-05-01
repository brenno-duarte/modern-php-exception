<!-- Server -->
<div class="modal fade modal-dialog-scrollable" id="server" tabindex="-1" aria-labelledby="server" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="server">Server</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
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
                <hr>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Extensions -->
<div class="modal fade" id="extensions" tabindex="-1" aria-labelledby="extensions" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="extensions">Extensions</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <?php foreach (get_loaded_extensions() as $value) : ?>
                    <code style="color: #000;"><?= "[" . $value . "]" ?></code>
                <?php endforeach; ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>