<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ModernPHPException: <?= $this->title ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/js/bootstrap.bundle.min.js"></script>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }

        .hidden {
            display: none;
        }

        .bg-info-exc {
            background-color: #DCDCDC;
        }

        /* Works on Firefox */
        * {
            scrollbar-width: #F5F5F5;
            scrollbar-color: #1874CD #F5F5F5;
        }

        /* Works on Chrome, Edge, and Safari */
        *::-webkit-scrollbar {
            width: 12px;
        }

        *::-webkit-scrollbar-track {
            background: #F5F5F5;
        }

        *::-webkit-scrollbar-thumb {
            background-color: #1874CD;
            border-radius: 20px;
            border: 3px solid #F5F5F5;
        }
    </style>
</head>

<body>
    <main>
        <div class="container-fluid">
            <div class="row bg-primary p-3">
                <div class="col-md-6">
                    <p class="h4 text-white">ModernPHPException</p>
                </div>

                <div class="col-md-6">
                    <p class="text-white d-flex flex-row-reverse bd-highlight">v<?= $this->version ?></p>
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