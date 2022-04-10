<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title><?= $this->getTitle() ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Ubuntu+Mono&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        pre {
            font-family: 'Open Sans', sans-serif;
        }

        .bench {
            position: fixed;
            bottom: 5px;
        }

        .hidden {
            display: none;
        }

        .message {
            word-wrap: break-word;
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

        <?= include_once 'bench-page.php' ?>
    </main>

    <script>
        window.onload = function() {
            for (var i = 0; i < 10; i++) {
                show('<?= $main_error ?>')
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