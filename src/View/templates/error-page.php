<?php if ($this->type == 'error') : ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-custom p-3">
        <div class="container-fluid">
            <div class="col-10 collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <h3 class="fw-bold"><?= '[' . $this->getError() . '] ' . $this->info_error_exception['message'] ?? "" ?></h3>
                    </li>
                </ul>
            </div>
            <div class="col-2 d-flex flex-row-reverse bd-highlight">
                <a href="https://stackoverflow.com/search?q=php+<?= strtolower(str_replace(" ", "+", $this->info_error_exception['message'])) ?>" target="_blank">
                    <img src="https://cdn.sstatic.net/Sites/stackoverflow/Img/favicon.ico?v=ec617d715196" title="Search in StackOverflow">
                </a>
            </div>
        </div>
    </nav>

<?php elseif ($this->type == 'exception') : ?>

    <nav class="navbar navbar-expand-lg navbar-light bg-custom p-3">
        <div class="container-fluid">
            <div class="col-10 collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <h3 class="fw-bold"><?= '[' . $this->info_error_exception['type_exception'] . '] ' . $this->info_error_exception['message'] ?></h3>
                    </li>
                </ul>
            </div>
            <div class="col-2 d-flex flex-row-reverse bd-highlight">
                <a href="https://stackoverflow.com/search?q=php+<?= strtolower(str_replace(" ", "+", $this->info_error_exception['message'])) ?>" target="_blank">
                    <img src="https://cdn.sstatic.net/Sites/stackoverflow/Img/favicon.ico?v=ec617d715196" title="Search in StackOverflow">
                </a>
            </div>
        </div>
    </nav>

    <?php
        $class_name = $this->info_error_exception['namespace_exception'];
        $exception = new \ReflectionClass($class_name);
    ?>

    <?php if (method_exists($exception, "getSolution")) : ?>
        <?php $exception->getMethod('getSolution')->invoke($class_name); ?>

        <nav class="navbar navbar-expand-lg navbar-light bg-custom-2 p-3">
            <div class="container-fluid">
                <div>
                    <h5 class="mb-3">
                        <strong><?= $this->solution->getTitle() ?></strong>

                        <?php if (!empty($this->solution->getDescription()) || $this->solution->getDescription() != "") : ?>
                            <small><?= ": " . $this->solution->getDescription() ?></small>
                        <?php endif; ?>
                    </h5>

                    <?php if (!empty($this->solution->getDocs()['link']) || $this->solution->getDocs()['link'] != "") : ?>
                        <a target="_blank" class="btn-custom" href="<?= $this->solution->getDocs()['link'] ?>">
                            <?= $this->solution->getDocs()['button'] ?>
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    <?php endif; ?>

<?php endif; ?>