<?php

namespace ModernPHPException;

use ModernPHPException\Database\Connection;
use ModernPHPException\Trait\HelpersTrait;

abstract class Occurrences
{
    use HelpersTrait;

    /**
     * @var \PDO
     */
    private static \PDO $connection;
    
    /**
     * @var string
     */
    private static string $table_name = "mpe_occurrences";

    /**
     * @return void
     */
    private static function getConnection(): void
    {
        self::$connection = Connection::getInstance();
    }

    /**
     * @return bool
     * @throws PDOException
     */
    private static function createOcurrenceTableInDb(): bool
    {
        self::getConnection();

        $sql = "CREATE TABLE IF NOT EXISTS " . self::$table_name . " (
            id INT AUTO_INCREMENT PRIMARY KEY,
            type_error VARCHAR(255) NOT NULL,
            description_error VARCHAR(255) NOT NULL,
            url_occurrence VARCHAR(100) NOT NULL,
            file_occurrence VARCHAR(100) NOT NULL,
            line_occurrence INT NOT NULL,
            times_occurrence INT NOT NULL,
            first_occurrence DATE NOT NULL,
            last_occurrence DATE NOT NULL,
            is_production BOOLEAN NOT NULL
        );";

        try {
            $stmt = self::$connection->prepare($sql);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    /**
     * @param string $type_error
     * @param string $description_error
     * @param string $url_occurrence
     * @param string $file_occurrence
     * @param int $line_occurrence
     * @param int $times_occurrence
     * @param string $first_occurrence
     * @param string $last_occurrence
     * @param bool $is_production
     * 
     * @return bool
     * @throws PDOException
     */
    private static function registerOccurrence(
        string $type_error,
        string $description_error,
        string $url_occurrence,
        string $file_occurrence,
        int $line_occurrence,
        int $times_occurrence,
        string $first_occurrence,
        string $last_occurrence,
        bool $is_production
    ): bool {
        self::getConnection();

        $numb_occurrences = self::verifyOccurrence($description_error);

        if (empty($numb_occurrences)) {
            $sql = "INSERT INTO " . self::$table_name . " 
            (type_error, description_error, url_occurrence, file_occurrence, 
            line_occurrence, times_occurrence, first_occurrence, last_occurrence, is_production)
            VALUES 
            (:type_error, :description_error, :url_occurrence, :file_occurrence, 
            :line_occurrence, :times_occurrence, :first_occurrence, :last_occurrence, :is_production)";
        } else {
            $sql = "UPDATE " . self::$table_name . " SET
            times_occurrence = " . (int)$numb_occurrences['times_occurrence'] . " + 1,
            last_occurrence = '" . date('Y-m-d') . "',
            is_production = :is_production WHERE description_error = :description_error";
        }

        try {
            $stmt = self::$connection->prepare($sql);

            if (empty($numb_occurrences)) {
                $stmt->bindParam(':type_error', $type_error, \PDO::PARAM_STR);
                $stmt->bindParam(':url_occurrence', $url_occurrence, \PDO::PARAM_STR);
                $stmt->bindParam(':file_occurrence', $file_occurrence, \PDO::PARAM_STR);
                $stmt->bindParam(':line_occurrence', $line_occurrence, \PDO::PARAM_INT);
                $stmt->bindParam(':times_occurrence', $times_occurrence, \PDO::PARAM_INT);
                $stmt->bindParam(':first_occurrence', $first_occurrence, \PDO::PARAM_STR);
                $stmt->bindParam(':last_occurrence', $last_occurrence, \PDO::PARAM_STR);
            }

            $stmt->bindParam(':description_error', $description_error, \PDO::PARAM_STR);
            $stmt->bindParam(':is_production', $is_production, \PDO::PARAM_BOOL);
            return $stmt->execute();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    /**
     * @param string $description_error
     * 
     * @return mixed
     * @throws PDOException
     */
    private static function verifyOccurrence(string $description_error): mixed
    {
        self::getConnection();

        $sql = "SELECT * FROM " . self::$table_name . " WHERE description_error = '" . $description_error . "'";

        try {
            $stmt = self::$connection->query($sql);
            $stmt->execute();
            return $stmt->fetch();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    /**
     * @return mixed
     * @throws PDOException
     */
    public static function listOccurrences(): mixed
    {
        self::getConnection();

        $sql = "SELECT * FROM " . self::$table_name . " ORDER BY last_occurrence DESC";

        try {
            $stmt = self::$connection->query($sql);
            $stmt->execute();
            return $stmt->fetchAll();
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage());
        }
    }

    /**
     * @param array $info_error_exception
     * @param string $type_error
     * @param bool $is_production
     * 
     * @return void
     */
    public static function enable(array $info_error_exception, string $type_error, bool $is_production): void
    {
        self::createOcurrenceTableInDb();
        self::registerOccurrence(
            $type_error,
            $info_error_exception['message'],
            self::getUri(),
            $info_error_exception['file'],
            $info_error_exception['line'],
            1,
            date('Y-m-d'),
            date('Y-m-d'),
            $is_production
        );
    }
}
