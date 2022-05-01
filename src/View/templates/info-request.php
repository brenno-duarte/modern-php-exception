<section class="hidden bg-main-info-exc rounded-3 p-3" id="requestvariablesid">
    <p><span class="label">HTTP STATUS: </span>
        <span class="bg-info-exc"><?= http_response_code() ?></span>
    </p>

    <span class="label">
        <p>GET:</p>
    </span>
    <?php foreach ($_GET as $key => $value) : ?>
        <p>
        <pre><span class="bg-info-exc"><?= $key ?></span>:  <?= filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></pre>
        </p>
    <?php endforeach; ?>

    <span class="label">
        <p>POST:</p>
    </span>
    <?php foreach ($_POST as $key => $value) : ?>
        <p>
        <pre><span class="bg-info-exc"><?= $key ?></span>: <?= filter_var($value, FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?></pre>
        </p>
    <?php endforeach; ?>

    <span class="label">
        <p>COOKIE:</p>
    </span>
    <?php foreach ($_COOKIE as $key => $value) : ?>
        <p>
        <pre><span class="bg-info-exc"><?= $key ?></span>: <?= $value ?></pre>
        </p>
    <?php endforeach; ?>

    <span class="label">
        <p>FILES:</p>
    </span>
    <?php foreach ($_FILES as $key => $value) : ?>
        <p>
        <pre><span class="bg-info-exc"><?= $key ?></span>: <?= $value ?></pre>
        </p>
    <?php endforeach; ?>
</section>