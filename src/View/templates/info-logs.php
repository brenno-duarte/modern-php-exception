<!-- Logs -->
<section class="hidden bg-main-info-exc rounded-3 p-3" id="logsid">
    <h6 class="txt-dark-theme">Logs</h6>
    <small>Logs have a limit of 10 results</small>

    <code>
    <?php
        $i = 0;
        $file = sys_get_temp_dir() . DIRECTORY_SEPARATOR . "ModernPHPExceptionLogs" . DIRECTORY_SEPARATOR . "ModernPHPExceptionLogs.log";
        clearstatcache(true, $file);

        if (isset(self::$config_yaml['dir_logs']) && self::$config_yaml['dir_logs'] != "") {
            $file = self::$config_yaml['dir_logs'] . DIRECTORY_SEPARATOR . "ModernPHPExceptionLogs.log";
        }

        if (file_exists($file)) {
            $logs = array_reverse(file($file));

            foreach ($logs as $value) if ($i < 10) {
                echo "<br>" . $value . "<br>";
                $i += 1;
            }
        } else {
            echo "<p>No log file found</p>";
        }
    ?>
    </code>

</section>