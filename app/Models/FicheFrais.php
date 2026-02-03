<?php
namespace Models;

use Config\Database;

final class FicheFrais
{
    public static function findAll(): array
    {
        $pdo = Database::get();
        $sql = "
            SELECT
                ff.IDvisiteur,
                ff.mois,
                ff.nbrJustificatifs,
                ff.montantValide,
                ff.dateModif,
                ff.idLigneFraisHorsForfait,
                lhf.libelle AS lhf_libelle,
                ff.idEtat,
                e.libelle AS etat_libelle,
                v.NOM AS visiteur_nom,
                v.PRENOM AS visiteur_prenom
            FROM fichefrais ff
            INNER JOIN visiteur v ON v.ID = ff.IDvisiteur
            INNER JOIN etat e ON e.ID = ff.idEtat
            LEFT JOIN lignefraishorforfait lhf ON lhf.ID = ff.idLigneFraisHorsForfait
            ORDER BY ff.mois DESC, v.NOM ASC, v.PRENOM ASC
        ";
        return $pdo->query($sql)->fetchAll();
    }

    public static function findByPk(int $idVisiteur, int $mois): ?array
    {
        $pdo = Database::get();
        $sql = "
            SELECT
                ff.IDvisiteur,
                ff.mois,
                ff.nbrJustificatifs,
                ff.montantValide,
                ff.dateModif,
                ff.idLigneFraisHorsForfait,
                lhf.libelle AS lhf_libelle,
                ff.idEtat,
                e.libelle AS etat_libelle,
                v.NOM AS visiteur_nom,
                v.PRENOM AS visiteur_prenom
            FROM fichefrais ff
            INNER JOIN visiteur v ON v.ID = ff.IDvisiteur
            INNER JOIN etat e ON e.ID = ff.idEtat
            LEFT JOIN lignefraishorforfait lhf ON lhf.ID = ff.idLigneFraisHorsForfait
            WHERE ff.IDvisiteur = :idVisiteur AND ff.mois = :mois
            LIMIT 1
        ";
        $st = $pdo->prepare($sql);
        $st->execute(['idVisiteur' => $idVisiteur, 'mois' => $mois]);
        $row = $st->fetch();
        return $row ?: null;
    }

    public static function create(
        int $idVisiteur,
        int $mois,
        int $nbrJustificatifs,
        int $montantValide,
        string $dateModif,
        int $idLigneFraisHorsForfait,
        int $idEtat
    ): bool {
        $pdo = Database::get();
        $sql = "
            INSERT INTO fichefrais
            (IDvisiteur, mois, nbrJustificatifs, montantValide, dateModif, idLigneFraisHorsForfait, idEtat)
            VALUES (?, ?, ?, ?, ?, ?, ?)
        ";
        $st = $pdo->prepare($sql);
        return $st->execute([
            $idVisiteur, $mois, $nbrJustificatifs, $montantValide, $dateModif, $idLigneFraisHorsForfait, $idEtat
        ]);
    }

    public static function update(
        int $idVisiteur,
        int $mois,
        int $nbrJustificatifs,
        int $montantValide,
        string $dateModif,
        int $idLigneFraisHorsForfait,
        int $idEtat
    ): bool {
        $pdo = Database::get();
        $sql = "
            UPDATE fichefrais
            SET nbrJustificatifs = ?,
                montantValide = ?,
                dateModif = ?,
                idLigneFraisHorsForfait = ?,
                idEtat = ?
            WHERE IDvisiteur = ? AND mois = ?
        ";
        $st = $pdo->prepare($sql);
        return $st->execute([
            $nbrJustificatifs,
            $montantValide,
            $dateModif,
            $idLigneFraisHorsForfait,
            $idEtat,
            $idVisiteur,
            $mois
        ]);
    }

    public static function delete(int $idVisiteur, int $mois): bool
    {
        $pdo = Database::get();
        $st  = $pdo->prepare("DELETE FROM fichefrais WHERE IDvisiteur = ? AND mois = ?");
        return $st->execute([$idVisiteur, $mois]);
    }
}
