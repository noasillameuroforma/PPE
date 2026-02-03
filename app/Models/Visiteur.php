<?php
namespace Models;

use Config\Database;

final class Visiteur
{
    public static function findAllLite(): array
    {
        $pdo = Database::get();
        $sql = "SELECT ID, NOM, PRENOM FROM visiteur ORDER BY NOM, PRENOM";
        return $pdo->query($sql)->fetchAll();
    }
}
