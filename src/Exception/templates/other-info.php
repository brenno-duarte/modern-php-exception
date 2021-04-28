<div class="accordion-item">
    <h2 class="accordion-header" id="inputDetails">
        <button class="accordion-button collapsed bg-info-exc text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseInput" aria-expanded="false" aria-controls="collapseInput">
            INPUT DATA
        </button>
    </h2>
    <div id="collapseInput" class="accordion-collapse collapse" aria-labelledby="inputDetails" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <p><strong>GET:</strong></p>
            <?php foreach ($_GET as $key => $value) : ?>
                <p><pre><?= "[" . $key . "]" . " => " . $value ?></pre></p>
                <hr>
            <?php endforeach; ?>

            <p><strong>POST:</strong></p>
            <?php foreach ($_POST as $key => $value) : ?>
                <p><pre><?= "[" . $key . "]" . " => " . $value ?></pre></p>
                <hr>
            <?php endforeach; ?>

            <p><strong>COOKIE:</strong></p>
            <?php foreach ($_COOKIE as $key => $value) : ?>
                <p><pre><?= "[" . $key . "]" . " => " . $value ?></pre></p>
                <hr>
            <?php endforeach; ?>

            <p><strong>FILES:</strong></p>
            <?php foreach ($_FILES as $key => $value) : ?>
                <p><pre><?= "[" . $key . "]" . " => " . $value ?></pre></p>
                <hr>
            <?php endforeach; ?>
        </div>
    </div>
</div>

<div class="accordion-item">
    <h2 class="accordion-header" id="serverDetails">
        <button class="accordion-button collapsed bg-info-exc text-dark" type="button" data-bs-toggle="collapse" data-bs-target="#collapseServer" aria-expanded="false" aria-controls="collapseServer">
            SERVER
        </button>
    </h2>
    <div id="collapseServer" class="accordion-collapse collapse" aria-labelledby="serverDetails" data-bs-parent="#accordionExample">
        <div class="accordion-body">
            <?php foreach ($_SERVER as $key => $value) : ?>
                <p><pre><?= "[" . $key . "]" . " => " . $value ?></pre></p>
                <hr>
            <?php endforeach; ?>

            <p><pre><?= "[PHP Version]" . " => " . phpversion() ?></pre></p>
            <hr>
        </div>
    </div>
</div>