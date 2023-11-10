<?php

if ($this->type == 'error') {
    $type = '[' . $this->getError() . '] ' . $this->info_error_exception['message'] ?? "";
} elseif ($this->type == 'exception') {
    $exception = new $this->info_error_exception['namespace_exception'];

    if (method_exists($exception, "getSolution")) {
        $exception->getSolution();

        $solution_title = $this->solution->getTitle();

        if (!empty($this->solution->getDescription()) || $this->solution->getDescription() != "") {
            $solution_desc = $this->solution->getDescription();
        }

        if (!empty($this->solution->getDocs()['link']) || $this->solution->getDocs()['link'] != "") {
            $solution_link = $this->solution->getDocs()['link'];
            $solution_button = $this->solution->getDocs()['button'];
        }
    }

    $type = '[' . $this->info_error_exception['type_exception'] . '] ' . $this->info_error_exception['message'];
}

$message = $this->info_error_exception['message'];
$file = $this->info_error_exception['file'];
$line = $this->getPathInfo($this->info_error_exception['line']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $this->getTitle() ?></title>
    <style>
        body {
            font-family: sans-serif;
        }

        h1 {
            font-size: 25px;
        }

        table tr th {
            padding-right: 20px;
            text-align: left;
        }

        code {
            font-size: 15px;
        }
    </style>
</head>

<body>
    <h1><?= $type ?></h1>

    <table>
        <tr>
            <th>Message: </th>
            <td><?= $message ?></td>
        </tr>
        <tr>
            <th>File: </th>
            <td><?= $file ?></td>
        </tr>
        <tr>
            <th>Line: </th>
            <td><?= $line ?></td>
        </tr>

        <?php if (isset($solution_title)) : ?>
            <tr>
                <th>Solution: </th>
                <td><?= $solution_title ?></td>
            </tr>
            <tr>
                <th>Description: </th>
                <td><?= $solution_desc ?></td>
            </tr>
            <tr>
                <th>Link: </th>
                <td><a href="<?= $solution_link ?>" target="_blank"><?= $solution_button ?></a></td>
            </tr>
        <?php endif; ?>
    </table>

    <?php if (!empty($this->trace)) : ?>
        <p><strong>Trace</strong></p>

        <?php foreach ($this->trace as $trace) : ?>
            # <code><?= $trace['file'] ?></code>
        <?php endforeach ?>
    <?php endif; ?>

    <script>
        <?= $this->consoleJS() ?>
    </script>
</body>

</html>