<?php


 
class db{
	public static $conn;
	function __construction(){
	
	}


	 private $query;
    private $params = [];
    private static $pdo;
    private static $encryptionKey;

    // Initialize PDO and encryption key for static use
    private static function init(): void {
        if (self::$pdo === null) {
            $dbConsts = db_config::constant_variable();
            self::$pdo = new PDO(
                'mysql:host=' . $dbConsts["hostname"] . ';dbname=' . $dbConsts["database"], 
                $dbConsts["username"], 
                $dbConsts["password"]
            );
            self::$encryptionKey = configurations::systemkey();
        }
        return;
    }

     // Static method to insert with encryption and optional uniqueness check
    public static function store($table, $columns, $values, $uniqueColumns = []) {
        try {
            // Initialize PDO and encryption key
            self::init();
            // Ensure $columns and $values have the same number of elements
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

            // Prepare columns and placeholders
            $columnsList = implode(', ', $columns);
            $placeholders = [];

            // Encrypt each value and set placeholders
            foreach ($values as $value) {
                $placeholders[] = "AES_ENCRYPT(?, '" . self::$encryptionKey . "')";
            }

            // Prepare the query
            $placeholdersList = implode(', ', $placeholders);
            $sql = "INSERT INTO $table ($columnsList) VALUES ($placeholdersList)";

            // Prepare the PDO statement
            $stmt = self::$pdo->prepare($sql);

            // Bind values to the prepared statement
            foreach ($values as $index => $value) {
                $value = trim($value);
                $stmt->bindValue($index + 1, $value); 
            }

            // Execute the query
            if ($stmt->execute()) {
                return self::successResponse("Data inserted successfully.");
            }
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage());
        }
    }


    public static function select($table, $columns = [], $where = [], $limit = null): array {
        try {
            // Initialize PDO and encryption key
            self::init();
            
            // If no columns are provided, select all (*) but decrypt all except 'id'
            if (empty($columns)) {
                $sql = "SHOW COLUMNS FROM $table";
                $stmt = self::$pdo->prepare($sql);
                $stmt->execute();
                $allColumns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    
                $columns = [];
                foreach ($allColumns as $col) {
                    if ($col === 'id') {
                        $columns[] = $col;
                    } else {
                        $columns[] = "AES_DECRYPT($col, '" . self::$encryptionKey . "') AS $col";
                    }
                }
            } else {
                foreach ($columns as $index => $col) {
                    if ($col !== 'id') {
                        $columns[$index] = "AES_DECRYPT($col, '" . self::$encryptionKey . "') AS $col";
                    }
                }
            }
    
            // Prepare columns for the SQL query
            $columnsList = implode(', ', $columns);
    
            // Construct the basic SQL query
            $sql = "SELECT $columnsList FROM $table";
    
            // Handle WHERE conditions, if any
            $conditions = [];
            $params = [];
            if (!empty($where)) {
                foreach ($where as $column => $value) {
                    $conditions[] = "$column = AES_ENCRYPT(:$column, '" . self::$encryptionKey . "')";
                    $params[":$column"] = trim($value); // Bind parameters using named placeholders
                }
                $sql .= " WHERE " . implode(' AND ', $conditions);
            }
    
            // Append LIMIT if provided
            if ($limit !== null) {
                $sql .= " LIMIT :limit"; // Use named placeholder for limit
            }
    
            // Prepare the SQL query
            $stmt = self::$pdo->prepare($sql);
    
            // Bind values (WHERE clause)
            foreach ($params as $param => $value) {
                $stmt->bindValue($param, $value);
            }
    
            // Bind the LIMIT as an integer (important to cast as integer)
            if ($limit !== null) {
                $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
            }
    
            // Execute the query
            $stmt->execute();
    
            // Return the fetched results
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
    
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage());
        }
    }
    
    public static function update($table, $data, $where): array {
        try {
            // Initialize PDO and encryption key
            self::init();
    
            // Ensure data and where are not empty
            if (empty($data) || empty($where)) {
                throw new Exception("Data and conditions for update cannot be empty.");
            }
    
            // Prepare the SET clause and WHERE clause
            $setClauses = [];
            $whereClauses = [];
            $params = [];
    
            // Prepare SET clause for data
            foreach ($data as $column => $value) {
                if ($column !== 'id') { // Do not encrypt ID
                    $setClauses[] = "$column = AES_ENCRYPT(?, '" . self::$encryptionKey . "')";
                    $params[] = trim($value); // Trim the value before binding
                }
            }
    
            // Prepare WHERE clause for conditions
            foreach ($where as $column => $value) {
                if ($column === 'id') {
                    // Use ID directly without encryption
                    $whereClauses[] = "$column = ?";
                    $params[] = $value; // ID is not encrypted
                } else {
                    // Encrypt other conditions
                    $whereClauses[] = "$column = AES_ENCRYPT(?, '" . self::$encryptionKey . "')";
                    $params[] = trim($value); // Encrypt the WHERE clause values
                }
            }
    
            // Prepare the SQL query
            $setClause = implode(', ', $setClauses);
            $whereClause = implode(' AND ', $whereClauses);
            $sql = "UPDATE $table SET $setClause WHERE $whereClause";
    
            // Prepare the PDO statement
            $stmt = self::$pdo->prepare($sql);
    
            // Bind values to the prepared statement
            foreach ($params as $index => $param) {
                $stmt->bindValue($index + 1, $param); // PDO uses 1-based index for placeholders
            }
    
            // Execute the query
            if ($stmt->execute()) {
                return self::successResponse("Data updated successfully.");
            } else {
                throw new Exception("Failed to update data.");
            }
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage());
        }
    }

    
    public static function delete($table, $where): array {
        try {
            // Initialize PDO and encryption key
            self::init();
    
            // Ensure where conditions are not empty
            if (empty($where)) {
                throw new Exception("Conditions for deletion cannot be empty.");
            }
    
            // Prepare WHERE clause
            $whereClauses = [];
            $params = [];
    
            foreach ($where as $column => $value) {
                if ($column === 'id') {
                    // Use ID directly without encryption
                    $whereClauses[] = "$column = ?";
                    $params[] = $value; // ID is not encrypted
                } else {
                    // Encrypt other conditions
                    $whereClauses[] = "$column = AES_ENCRYPT(?, '" . self::$encryptionKey . "')";
                    $params[] = trim($value); // Encrypt the WHERE clause values
                }
            }
    
            // Prepare the SQL query
            $whereClause = implode(' AND ', $whereClauses);
            $sql = "DELETE FROM $table WHERE $whereClause";
    
            // Prepare the PDO statement
            $stmt = self::$pdo->prepare($sql);
    
            // Bind values to the prepared statement
            foreach ($params as $index => $param) {
                $stmt->bindValue($index + 1, $param); // PDO uses 1-based index for placeholders
            }
    
            // Execute the query
            if ($stmt->execute()) {
                return self::successResponse("Data deleted successfully.");
            } else {
                throw new Exception("Failed to delete data.");
            }
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage());
        }
    }
    
    public static function truncate($table): array {
        try {
            // Initialize PDO and encryption key
            self::init();   
            // Prepare the SQL query for truncation
            $sql = "TRUNCATE TABLE $table";  
            // Execute the query
            self::$pdo->exec($sql);  
            return self::successResponse("Table '$table' truncated successfully.");
        } catch (Exception $e) {
            return self::errorResponse($e->getMessage());
        }
    }

    // Method to return error response
    private static function errorResponse($message) {
        return ["error" => $message];
    }

    // Method to return success response
    private static function successResponse($message) {
        return ["success" => $message];
    }

    // Check if a value is unique in the table for the given column
    private static function isUnique($table, $column, $value): bool {
        try {
            // Prepare the SQL query for checking uniqueness
            $sql = "SELECT COUNT(*) FROM $table WHERE $column = AES_ENCRYPT(?, '" . self::$encryptionKey . "')";
            $stmt = self::$pdo->prepare($sql);
            $stmt->bindValue(1, trim($value)); // Trim the value before binding
            $stmt->execute();
    
            // Return true if the count is zero (no duplicate found)
            return $stmt->fetchColumn() == 0;
        } catch (Exception $e) {
            throw new Exception("Error checking uniqueness: " . $e->getMessage());
        }
    }





	 static function createion(){
		$varaibv = db_config::constant_variable();
		$conn = new mysqli($varaibv['hostname'],$varaibv['username'],$varaibv['password'],$varaibv['database']);
        if ($conn->connect_error) {
        exit("Connection failed: " . $conn->connect_error);
         } 
		 return $conn;
		 }
	 static function connection(){
		 return db::$conn;
		
		}
	
	
	
	
	}















?>