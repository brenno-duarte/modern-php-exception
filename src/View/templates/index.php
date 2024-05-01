<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->getTitle() ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <?= $assets ?>
</head>

<body>
    <main>
        <header class="container-fluid">
            <div class="row mb-1">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                                <div class="navbar-nav">
                                    <a class="nav-link submenu text-uppercase" onclick="show('requestvariablesid')">
                                        <i class="bi bi-database"></i> Request Body
                                    </a>
                                    <a class="nav-link submenu text-uppercase" onclick="show('servervariablesid')">
                                        <i class="bi bi-hdd-stack"></i> Server Info
                                    </a>
                                    <a class="nav-link submenu text-uppercase" onclick="show('extensionsvariablesid')">
                                        <i class="bi bi-filetype-php"></i> Extensions
                                    </a>
                                    <a class="nav-link submenu text-uppercase" data-bs-toggle="modal" data-bs-target="#bench">
                                        <i class="bi bi-speedometer"></i> Benchmark
                                    </a>
                                    <a class="nav-link submenu text-uppercase" onclick="show('logsid')">
                                        <i class="bi bi-file-text"></i> Logs
                                    </a>
                                    <a class="nav-link submenu text-uppercase <?= ($this->is_occurrence_enabled === true) ? "" : "disabled" ?>" data-bs-toggle="modal" data-bs-target="#occurrencesid">
                                        <i class="bi bi-clipboard-data"></i> Occurrences
                                    </a>
                                </div>
                            </div>
                            <div>
                                <span class="version-number">PHP: <?= phpversion() ?></span>
                                <span class="btn-version version-number mr-3">v<?= ModernPHPException\ModernPHPException::VERSION ?></span>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>
        </header>

        <?php include_once 'error-page.php'; ?>

        <div class="container-fluid mt-5 mb-5">
            <div class="error-page" id="mainpageid">
                <div class="row">
                    <div class="col-md-4">
                        <div class="list-group">
                            <?php include_once 'info-trace.php'; ?>
                        </div>
                    </div>

                    <div class="col-md-8">
                        <?php

                        include_once 'code-error-exception.php';
                        include_once 'info-server.php';
                        include_once 'info-request.php';
                        include_once 'info-logs.php';

                        ?>
                    </div>
                </div>
            </div>
        </div>

        <?php include_once 'occurrence-page.php'; ?>
        <?php include_once 'bench-page.php'; ?>
    </main>

    <?php include_once 'javascript.php' ?>
</body>

</html>