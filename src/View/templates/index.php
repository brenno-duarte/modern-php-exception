<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->getTitle() ?></title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Mono&display=swap" rel="stylesheet">

    <?= $assets ?>

    <script src="https://cdn.jsdelivr.net/npm/less@4"></script>
</head>

<body>
    <main>
        <?php include_once 'error-page.php'; ?>

        <div class="container mt-5 mb-5">
            <div class="row mb-1">
                <div class="col-12">
                    <nav class="navbar navbar-expand-lg navbar-light bg-submenu">
                        <div class="container-fluid">
                            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                                <div class="navbar-nav">
                                    <a class="nav-link submenu" onclick="show('requestvariablesid')">Request Data</a>
                                    <a class="nav-link submenu" data-bs-toggle="modal" data-bs-target="#server">Server Info</a>
                                    <a class="nav-link submenu" data-bs-toggle="modal" data-bs-target="#extensions">Extensions</a>
                                </div>
                            </div>
                            <div>
                                <span class="version-number">PHP: <?= phpversion() ?></span>
                                <span class="btn-version version-number">v<?= ModernPHPException\ModernPHPException::VERSION ?></span>
                            </div>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="list-group">
                        <?php include_once 'info-trace.php'; ?>
                    </div>
                </div>

                <div class="col-md-8">
                    <?php

                    include_once 'info-error-exception.php';
                    include_once 'info-server.php';
                    include_once 'info-request.php';

                    ?>

                    <div class="mb-5"></div>
                </div>
            </div>
        </div>

        <button class="bench btn-custom" data-bs-toggle="modal" data-bs-target="#bench">Bench</button>

        <?= include_once 'bench-page.php'; ?>
    </main>

    <?= include_once 'javascript.php' ?>
</body>

</html>