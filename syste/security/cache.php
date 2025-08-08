<?php
class Cachee {
    private static $cache_time;
    private static $cache_file;

    static function get($r) {
        echo $r;
    }

    public static function init($cache_time = 3600) {
        self::$cache_time = $cache_time;
        self::$cache_file = 'cache/' . md5($_SERVER['REQUEST_URI']) . '.html';
    }

    // Check if a valid cache file exists
    public static function start() {
        if (file_exists(self::$cache_file) && (time() - filemtime(self::$cache_file)) < self::$cache_time) {
            readfile(self::$cache_file);
            exit;
        }
        ob_start();
    }

    // Save output to cache
    public static function end() {
        $output = ob_get_contents();
        file_put_contents(self::$cache_file, $output);
        ob_end_flush();
    }
}

