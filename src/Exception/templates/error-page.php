<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->getTitle() ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        pre {
            font-family: 'Open Sans', sans-serif;
        }

        .bench {
            position: absolute;
            top: 5px;
        }
    </style>
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6"></div>

                <div class="col-md-6">
                    <p class="text-dark d-flex flex-row-reverse bd-highlight">v<?= $this->version ?></p>
                </div>
            </div>
        </div>
        <div class="container mt-5 mb-5">
            <div class="row">
                <div class="col-md-4">
                    <div class="list-group">
                        <?php include_once 'info-trace.php'; ?>
                    </div>
                </div>

                <div class="col-md-8">
                    <?php include_once 'info-exception.php' ?>
                    <?php include_once 'info-error.php' ?>

                    <?php include_once 'info-server.php' ?>

                    <div class="mb-5"></div>
                </div>
            </div>
        </div>

        <button class="bench btn btn-warning" data-bs-toggle="modal" data-bs-target="#bench">Bench</button>

        <!-- Scrollable modal -->
        <div class="modal fade" id="bench" tabindex="-1" aria-labelledby="benchLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-body">
                        <p><strong>Elapse time:</strong> <?= $this->bench->getTime() ?></p>
                        <p><strong>Elapse microtime:</strong> <?= $this->bench->getTime(true) ?></p>
                        <p><strong>Elapse time format:</strong> <?= $this->bench->getTime(false, '%d%s') ?></p>
                        <p><strong>Memory peak:</strong> <?= $this->bench->getMemoryPeak() ?></p>
                        <p><strong>Memory peak in bytes:</strong> <?= $this->bench->getMemoryPeak(true) ?></p>
                        <p><strong>Memory peak format:</strong> <?= $this->bench->getMemoryPeak(false, '%.3f%s') ?></p>
                        <p><strong>Memory usage:</strong> <?= $this->bench->getMemoryUsage() ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <script>
        window.onload = function() {
            for (var i = 0; i < 10; i++) {
                show('<?= $this->main_file ?>')
            }
        };

        function show(id) {
            if (document.getElementById(id).style.display !== "none") {
                document.getElementById(id).style.display = "none";
                return;
            }
            Array.from(document.getElementsByClassName("hidden")).forEach(
                div => (div.style.display = "none")
            );
            document.getElementById(id).style.display = "block";
        }
    </script>
</body>

</html>