<?php
namespace Models;

use Config\Database;

final class LigneFraisHorsForfait
{
    public static function findAllLite(): array
    {
        $pdo = Database::get();
        $sql = "SELECT ID, libelle FROM lignefraishorforfait ORDER BY ID";
        return $pdo->query($sql)->fetchAll();
    }
}
