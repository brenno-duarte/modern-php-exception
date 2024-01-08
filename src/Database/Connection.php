<?php

namespace ModernPHPException\Database;

use ModernPHPException\ModernPHPException;
use ModernPHPException\Trait\RenderTrait;
use Symfony\Component\Yaml\Yaml;

abstract class Connection
{
    use RenderTrait;

    /**
     * @var \PDO
     */
    private static \PDO $pdo;

    /**
     * @var string
     */
    private static string $dns;

    /**
     * @var string|null
     */
    private static ?string $username = null;

    /**
     * @var string|null
     */
    private static ?string $password = null;

    /**
     * @var array|null
     */
    private static ?array $options = null;

    /**
     * @var array
     */
    private static array $config_file;

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    /**
     * @return array
     * @throws ConnectionException
     */
    private static function getConfigFile(): array
    {
        $config_file = ModernPHPException::getConfigFile();

        if (file_exists($config_file)) {
            self::$config_file = Yaml::parseFile($config_file);
            return self::$config_file;
        }

        throw new ConnectionException("File Config not found");
    }

    /**
     * Creates an instance of the connection
     * 
     * @return \PDO
     */
    public static function getInstance(): \PDO
    {
        $db_config = self::getConfigFile();

        self::getConnection($db_config['db_drive']);

        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new \PDO(self::$dns, self::$username, self::$password, self::$options);
                self::$pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
                self::$pdo->setAttribute(\PDO::ATTR_EMULATE_PREPARES, false);

                return self::$pdo;
            } catch (\Throwable $e) {
                self::renderFatalError($e, "Check if the YAML file is configured correctly");
                die;
            }
        }

        return self::$pdo;
    }

    /**
     * @param string $drive
     * 
     * @return void 
     */
    private static function verifyExtensions(string $drive): void
    {
        if ($drive == "mysql" && !extension_loaded('pdo_mysql')) {
            ConnectionException::driveNotFound($drive);
        }

        if ($drive == "sqlite" && !extension_loaded('pdo_sqlite')) {
            ConnectionException::driveNotFound($drive);
        }

        if ($drive == "pgsql" && !extension_loaded('pdo_pgsql')) {
            ConnectionException::driveNotFound($drive);
        }

        if ($drive == "oci" && !extension_loaded('pdo_oci')) {
            ConnectionException::driveNotFound($drive);
        }
    }

    /**
     * @param string $drive
     * 
     * @return void
     */
    private static function getConnection(string $drive): void
    {
        self::verifyExtensions($drive);

        if ($drive == "mysql") {
            self::connectionMySql($drive);
        } elseif ($drive == "pgsql") {
            self::connectionPgSql($drive);
        } elseif ($drive == "oci") {
            self::connectionOracle($drive);
        }
    }

    /**
     * @param string $drive
     * 
     * @return void
     */
    private static function connectionMySql(string $drive): void
    {
        $db_config = self::getConfigFile();

        self::$dns = $drive . ":host=" . $db_config['db_host'] .
            ";dbname=" . $db_config['db_name'] . ";charset=utf8";
        self::$username = $db_config['db_user'];
        self::$password = $db_config['db_pass'];
        self::$options = [\PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"];
    }

    /**
     * @param string $drive
     * 
     * @return void
     */
    private static function connectionPgSql(string $drive): void
    {
        $db_config = self::getConfigFile();

        self::$dns = $drive . ":host=" . $db_config['db_host'] . ";dbname=" . $db_config['db_name'];
        self::$username = $db_config['db_user'];
        self::$password = $db_config['db_pass'];
    }

    /**
     * @param string $drive
     * 
     * @return void
     */
    private static function connectionOracle(string $drive): void
    {
        $db_config = self::getConfigFile();

        self::$dns = $drive . ":dbname=" . $db_config['db_name'];
        self::$username = $db_config['db_user'];
        self::$password = $db_config['db_pass'];
    }
}
