<section class="hidden bg-main-info-exc rounded-3 p-3" id="requestvariablesid">
    <div class="accordion accordion-flush" id="accordion-request-get">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingOne">
                <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseOne" aria-expanded="false" aria-controls="flush-collapseOne">
                    <span class="bg-info-exc">GET data</span>
                </button>
            </h2>
            <div id="flush-collapseOne" class="accordion-collapse collapse" aria-labelledby="flush-headingOne" data-bs-parent="#accordion-request-get">

                <ul class="list-group list-group-flush">
                    <?php if (!empty($_GET)) : ?>
                        <?php foreach ($_GET as $key => $value) : ?>
                            <li class="list-group-item">
                                <span class="bg-info-exc"><?= $key ?>:</span> <span class="txt-dark-theme"><?= filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li class="list-group-item text-secondary">empty</li>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </div>

    <div class="accordion accordion-flush" id="accordion-request-post">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingTwo">
                <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo" aria-expanded="false" aria-controls="flush-collapseTwo">
                    <span class="bg-info-exc">POST data</span>
                </button>
            </h2>
            <div id="flush-collapseTwo" class="accordion-collapse collapse" aria-labelledby="flush-headingTwo" data-bs-parent="#accordion-request-post">

                <ul class="list-group list-group-flush">
                    <?php if (!empty($_POST)) : ?>
                        <?php foreach ($_POST as $key => $value) : ?>
                            <li class="list-group-item">
                                <span class="bg-info-exc"><?= $key ?>:</span> <span class="txt-dark-theme"><?= filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li class="list-group-item text-secondary">empty</li>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </div>

    <div class="accordion accordion-flush" id="accordion-request-cookie">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingThree">
                <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseThree" aria-expanded="false" aria-controls="flush-collapseThree">
                    <span class="bg-info-exc">COOKIE data</span>
                </button>
            </h2>
            <div id="flush-collapseThree" class="accordion-collapse collapse" aria-labelledby="flush-headingThree" data-bs-parent="#accordion-request-cookie">

                <ul class="list-group list-group-flush">
                    <?php if (!empty($_COOKIE)) : ?>
                        <?php foreach ($_COOKIE as $key => $value) : ?>
                            <li class="list-group-item">
                                <span class="bg-info-exc"><?= $key ?>:</span> <span class="txt-dark-theme"><?= $value ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li class="list-group-item text-secondary">empty</li>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </div>

    <div class="accordion accordion-flush" id="accordion-request-files">
        <div class="accordion-item">
            <h2 class="accordion-header" id="flush-headingFour">
                <button class="accordion-button collapsed bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapseFour" aria-expanded="false" aria-controls="flush-collapseFour">
                    <span class="bg-info-exc">FILES data</span>
                </button>
            </h2>
            <div id="flush-collapseFour" class="accordion-collapse collapse" aria-labelledby="flush-headingFour" data-bs-parent="#accordion-request-files">

                <ul class="list-group list-group-flush">
                    <?php if (!empty($_FILES)) : ?>
                        <?php foreach ($_FILES as $key => $value) : ?>
                            <li class="list-group-item">
                                <span class="bg-info-exc"><?= $key ?>:</span> <span class="txt-dark-theme"><?= $value ?></span>
                            </li>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <li class="list-group-item text-secondary">empty</li>
                    <?php endif; ?>
                </ul>

            </div>
        </div>
    </div>
</section>