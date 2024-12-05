<?php

function conectarDB(): mysqli
{
    $db = new mysqli('localhost', 'root', 'logiPruebas1.', 'noma');

    if (!$db) {
        echo "Error no se pudo conectar";
        exit;
    }
    return $db;
}
