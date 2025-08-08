<?php 

class Date {
    static function getDate($date) {
        $datetime = DateTime::createFromFormat('YmdHis', $date);
        return $datetime->format('d-M-Y');
    }
}