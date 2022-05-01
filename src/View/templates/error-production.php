<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300;0,400;0,600;0,700;0,800;1,300;1,400;1,600;1,700;1,800&display=swap" rel="stylesheet">
    <title>Server Error</title>
    <style>
        html,
        body {
            font-family: 'Open Sans', sans-serif;
        }

        h1 {
            font-size: 40px;
            font-weight: 400;
        }

        p {
            font-size: 20px;
        }

        .alert {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 500px;
        }

        .content {
            text-align: center;
            width: 100%;
        }
    </style>
</head>

<body>
    <div class="alert">
        <div class="content">
            <h1>Internal Server Error | <?= http_response_code() ?></h1>

            <?php if ($this->message_production != "") : ?>
                <p><?= $this->message_production ?></p>
            <?php else : ?>
                <p>Sorry, but there was an internal error processing your request. Try again later.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>