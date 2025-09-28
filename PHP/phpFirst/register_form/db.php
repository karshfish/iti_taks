<?php

declare(strict_types=1);

class DB
{
    private static $writeDBConnection;
    private static $readDBConnection;

    private function __construct() {}

    public static function connectWriteDB()
    {
        if (self::$writeDBConnection === null) {
            self::$writeDBConnection = new PDO(
                "mysql:host=127.0.0.1;dbname=user_management;charset=utf8",
                "root",
                ""
            );
            self::$writeDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$writeDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return self::$writeDBConnection;
    }

    public static function connectReadDB()
    {
        if (self::$readDBConnection === null) {
            self::$readDBConnection = new PDO(
                "mysql:host=127.0.0.1;dbname=user_management;charset=utf8",
                "root",
                ""
            );
            self::$readDBConnection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            self::$readDBConnection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        }
        return self::$readDBConnection;
    }

    // 🔹 Generic CREATE
    public static function create(string $table, array $data): int
    {
        $db = self::connectWriteDB();
        $columns = implode(", ", array_keys($data));
        $placeholders = ":" . implode(", :", array_keys($data));

        $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$placeholders})";
        $stmt = $db->prepare($sql);
        $stmt->execute($data);

        return (int) $db->lastInsertId();
    }

    // 🔹 Generic READ (with simple where)
    public static function read(string $table, array $where = []): array
    {
        $db = self::connectReadDB();
        $sql = "SELECT * FROM {$table}";
        if (!empty($where)) {
            $conditions = implode(" AND ", array_map(fn($col) => "{$col} = :{$col}", array_keys($where)));
            $sql .= " WHERE {$conditions}";
        }
        $stmt = $db->prepare($sql);
        $stmt->execute($where);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // 🔹 Generic UPDATE
    public static function update(string $table, array $data, array $where): bool
    {
        $db = self::connectWriteDB();
        $set = implode(", ", array_map(fn($col) => "{$col} = :{$col}", array_keys($data)));
        $conditions = implode(" AND ", array_map(fn($col) => "{$col} = :where_{$col}", array_keys($where)));

        $sql = "UPDATE {$table} SET {$set} WHERE {$conditions}";
        $stmt = $db->prepare($sql);

        // Merge both with prefixed keys
        foreach ($where as $col => $val) {
            $data["where_{$col}"] = $val;
        }

        return $stmt->execute($data);
    }

    // 🔹 Generic DELETE
    public static function delete(string $table, array $where): bool
    {
        $db = self::connectWriteDB();
        $conditions = implode(" AND ", array_map(fn($col) => "{$col} = :{$col}", array_keys($where)));

        $sql = "DELETE FROM {$table} WHERE {$conditions}";
        $stmt = $db->prepare($sql);
        return $stmt->execute($where);
    }
}
