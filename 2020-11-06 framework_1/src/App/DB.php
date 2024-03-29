<?php

namespace App;

class DB {
    static $db = null;
    static function getDB() {
        if(self::$db == null) {
            self::$db = new \PDO("mysql:host=localhost;dbname=dbname;charset=utf8mb4", "root", "", [
                19 => 5,
                3 => 2
            ]);
        }

        return self::$db;
    }

    static function query($sql, $data = []) {
        $q = self::getDB()->prepare($sql);
        $q->execute($data);
        return $q;
    }

    static function fetch($sql, $data = []) {
        return self::query($sql, $data)->fetch();
    }
    
    static function fetchAll($sql, $data = []) {
        return self::query($sql, $data)->fetchAll();
    }
}