<?php
class DBB
{
    private $query;
    private $params = [];
    private static $pdo;

    // Initialize PDO for static use
    private static function init(): void
    {
        if (self::$pdo === null) {
            $dbConsts = db_config::constant_variable();
            self::$pdo = new PDO(
                'mysql:host=' . $dbConsts["hostname"] . ';dbname=' . $dbConsts["database"],
                $dbConsts["username"],
                $dbConsts["password"]
            );
        }
        return;
    }

    // Static method to insert without encryption
    public static function store($table, $columns, $values, $uniqueColumns = [])
    {
        try {
            self::init();

            if (count($columns) !== count($values)) {
                throw new Exception("The number of columns must match the number of values.");
            }

            // Check if any unique columns are provided and check uniqueness
            if (!empty($uniqueColumns)) {
                foreach ($uniqueColumns as $uniqueColumn) {
                    if (!self::isUnique($table, $uniqueColumn, $values[array_search($uniqueColumn, $columns)])) {
                        throw new Exception("The value for '$uniqueColumn' must be unique.");
                    }
                }
            }

            $columnsList = implode(', ', $columns);
            $placeholders = implode(', ', array_fill(0, count($values), '?'));

            $sql = "INSERT INTO $table ($columnsList) VALUES ($placeholders)";
            $stmt = self::$pdo->prepare($sql);

            foreach ($values as $index => $value) {
                $stmt->bindValue($index + 1, trim($value));
            }

            if ($stmt->execute()) {
                return self::successResponse("Data inserted successfully.");
            }
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage());
        }
    }

    // Static method to select without decryption
    public static function select($table, $columns = [], $where = [], $limit = null): array
    {
        try {
            self::init();

            $columnsList = empty($columns) ? '*' : implode(', ', $columns);

            $sql = "SELECT $columnsList FROM $table";
            $conditions = [];
            $params = [];

            if (!empty($where)) {
                foreach ($where as $column => $value) {
                    $conditions[] = "$column = ?";
                    $params[] = trim($value);
                }
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }

            if ($limit !== null) {
                $sql .= " LIMIT :limit";
            }

            $stmt = self::$pdo->prepare($sql);

            foreach ($params as $index => $value) {
                $stmt->bindValue($index + 1, $value);
            }

            if ($limit !== null) {
                $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage());
        }
    }

    // Static method to update without encryption
    public static function update($table, $data, $where): array
    {
        try {
            self::init();

            if (empty($data) || empty($where)) {
                throw new Exception("Data and conditions for update cannot be empty.");
            }

            $setClauses = [];
            $whereClauses = [];
            $params = [];

            foreach ($data as $column => $value) {
                $setClauses[] = "$column = ?";
                $params[] = trim($value);
            }

            foreach ($where as $column => $value) {
                $whereClauses[] = "$column = ?";
                $params[] = trim($value);
            }

            $setClause = implode(', ', $setClauses);
            $whereClause = implode(' AND ', $whereClauses);
            $sql = "UPDATE $table SET $setClause WHERE $whereClause";

            $stmt = self::$pdo->prepare($sql);

            foreach ($params as $index => $param) {
                $stmt->bindValue($index + 1, $param);
            }

            if ($stmt->execute()) {
                return self::successResponse("Data updated successfully.");
            } else {
                throw new Exception("Failed to update data.");
            }
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage());
        }
    }

    // Static method to delete without encryption
    public static function delete($table, $where): array
    {
        try {
            self::init();

            if (empty($where)) {
                throw new Exception("Conditions for deletion cannot be empty.");
            }

            $whereClauses = [];
            $params = [];

            foreach ($where as $column => $value) {
                $whereClauses[] = "$column = ?";
                $params[] = trim($value);
            }

            $whereClause = implode(' AND ', $whereClauses);
            $sql = "DELETE FROM $table WHERE $whereClause";

            $stmt = self::$pdo->prepare($sql);

            foreach ($params as $index => $param) {
                $stmt->bindValue($index + 1, $param);
            }

            if ($stmt->execute()) {
                return self::successResponse("Data deleted successfully.");
            } else {
                throw new Exception("Failed to delete data.");
            }
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage());
        }
    }

    // Static method to check uniqueness without encryption
    private static function isUnique($table, $column, $value): bool
    {
        try {
            $sql = "SELECT COUNT(*) FROM $table WHERE $column = ?";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindValue(1, trim($value));
            $stmt->execute();

            return $stmt->fetchColumn() == 0;
        } catch (Exception $e) {
            throw new Exception("Error checking uniqueness: " . $e->getMessage());
        }
    }

    public static function truncate($table): array
    {
        try {
            self::init();
            $sql = "TRUNCATE TABLE $table";
            self::$pdo->exec($sql);
            return self::successResponse("Table '$table' truncated successfully.");
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage());
        }
    }

    private static function errorResponse($message)
    {
        return ["error" => $message];
    }

    private static function successResponse($message)
    {
        return ["success" => $message];
    }

    
}
