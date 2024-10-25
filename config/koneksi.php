<?php

const DB_HOST = 'localhost';
const DB_NAME = 'db_latihan';
const DB_USER = 'root';
const DB_PASS = '';
const DSN = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME;
const DB_OPTIONS = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

function koneksi(): PDO
{
    try {
        return new PDO(DSN, DB_USER, DB_PASS, DB_OPTIONS);
    } catch (PDOException $e) {
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
}