<?php
namespace Controllers;

use Core\Controller;
use Models\FicheFrais;
use Models\Etat;
use Models\Visiteur;
use Models\LigneFraisHorsForfait;

final class FicheFraisController extends Controller
{
    public function index(): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        try {
            $fiches = FicheFrais::findAll();
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Impossible de charger les fiches frais.";
            $fiches = [];
        }

        $this->render('fichefrais/index', [
            'title'   => 'Liste des fiches frais',
            'fiches'  => $fiches,
            'message' => $_SESSION['flash'] ?? '',
        ]);
        unset($_SESSION['flash']);
    }

    public function show($idVisiteur, $mois): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        $idVisiteur = (int)$idVisiteur;
        $mois       = (int)$mois;

        try {
            $fiche = FicheFrais::findByPk($idVisiteur, $mois);
            if (!$fiche) {
                $_SESSION['flash'] = "Fiche introuvable.";
                $this->redirect('/ficheFrais');
            }
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors du chargement.";
            $this->redirect('/ficheFrais');
        }

        $this->render('fichefrais/show', [
            'title'   => 'Détail fiche frais',
            'fiche'   => $fiche,
            'message' => $_SESSION['flash'] ?? '',
        ]);
        unset($_SESSION['flash']);
    }

    public function create(): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        $this->render('fichefrais/create', [
            'title'    => 'Créer une fiche frais',
            'message'  => $_SESSION['flash'] ?? '',
            'old'      => $_SESSION['old'] ?? [
                'IDvisiteur' => '',
                'mois' => '',
                'nbrJustificatifs' => '0',
                'montantValide' => '0',
                'dateModif' => date('Y-m-d'),
                'idLigneFraisHorsForfait' => '',
                'idEtat' => '',
            ],
            'errors'   => $_SESSION['errors'] ?? [],
            'visiteurs'=> Visiteur::findAllLite(),
            'etats'    => Etat::findAll(),
            'lhf'      => LigneFraisHorsForfait::findAllLite(),
        ]);

        unset($_SESSION['flash'], $_SESSION['old'], $_SESSION['errors']);
    }

    public function store(): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        $idVisiteur = (int)($_POST['IDvisiteur'] ?? 0);
        $mois       = (int)($_POST['mois'] ?? 0);
        $nbrJust    = (int)($_POST['nbrJustificatifs'] ?? 0);
        $montant    = (int)($_POST['montantValide'] ?? 0);
        $dateModif  = trim($_POST['dateModif'] ?? '');
        $idLhf      = (int)($_POST['idLigneFraisHorsForfait'] ?? 0);
        $idEtat     = (int)($_POST['idEtat'] ?? 0);

        $errors = [];
        if ($idVisiteur <= 0) $errors['IDvisiteur'] = "Visiteur obligatoire.";
        if ($mois <= 0) $errors['mois'] = "Mois obligatoire (ex: 202508).";
        if ($dateModif === '') $errors['dateModif'] = "Date obligatoire.";
        if ($idEtat <= 0) $errors['idEtat'] = "État obligatoire.";
        if ($idLhf <= 0) $errors['idLigneFraisHorsForfait'] = "Ligne hors forfait obligatoire.";

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $_SESSION['flash'] = "Merci de corriger les erreurs.";
            $this->redirect('ficheFrais/create');
        }

        try {
            FicheFrais::create($idVisiteur, $mois, $nbrJust, $montant, $dateModif, $idLhf, $idEtat);
            $_SESSION['flash'] = "Fiche créée avec succès.";
            $this->redirect("./ficheFrais/$idVisiteur/$mois");
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Impossible de créer la fiche (PK déjà existante ?).";
            $this->redirect('/ficheFrais');
        }
    }

    public function edit($idVisiteur, $mois): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        $idVisiteur = (int)$idVisiteur;
        $mois       = (int)$mois;

        try {
            $fiche = FicheFrais::findByPk($idVisiteur, $mois);
            if (!$fiche) {
                $_SESSION['flash'] = "Fiche introuvable.";
                $this->redirect('/ficheFrais');
            }
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors du chargement.";
            $this->redirect('/ficheFrais');
        }

        $old = $_SESSION['old'] ?? [
            'nbrJustificatifs' => $fiche['nbrJustificatifs'],
            'montantValide' => $fiche['montantValide'],
            'dateModif' => $fiche['dateModif'],
            'idLigneFraisHorsForfait' => $fiche['idLigneFraisHorsForfait'],
            'idEtat' => $fiche['idEtat'],
        ];

        $this->render('fichefrais/edit', [
            'title'    => 'Modifier fiche frais',
            'fiche'    => $fiche,
            'old'      => $old,
            'errors'   => $_SESSION['errors'] ?? [],
            'message'  => $_SESSION['flash'] ?? '',
            'etats'    => Etat::findAll(),
            'lhf'      => LigneFraisHorsForfait::findAllLite(),
        ]);

        unset($_SESSION['old'], $_SESSION['errors'], $_SESSION['flash']);
    }

    public function update($idVisiteur, $mois): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        $idVisiteur = (int)$idVisiteur;
        $mois       = (int)$mois;

        $nbrJust   = (int)($_POST['nbrJustificatifs'] ?? 0);
        $montant   = (int)($_POST['montantValide'] ?? 0);
        $dateModif = trim($_POST['dateModif'] ?? '');
        $idLhf     = (int)($_POST['idLigneFraisHorsForfait'] ?? 0);
        $idEtat    = (int)($_POST['idEtat'] ?? 0);

        $errors = [];
        if ($dateModif === '') $errors['dateModif'] = "Date obligatoire.";
        if ($idEtat <= 0) $errors['idEtat'] = "État obligatoire.";
        if ($idLhf <= 0) $errors['idLigneFraisHorsForfait'] = "Ligne hors forfait obligatoire.";

        if ($errors) {
            $_SESSION['errors'] = $errors;
            $_SESSION['old'] = $_POST;
            $_SESSION['flash'] = "Merci de corriger les erreurs.";
            $this->redirect("/ficheFrais/$idVisiteur/$mois/edit");
        }

        try {
            FicheFrais::update($idVisiteur, $mois, $nbrJust, $montant, $dateModif, $idLhf, $idEtat);
            $_SESSION['flash'] = "Fiche modifiée avec succès.";
            $this->redirect("/ficheFrais/$idVisiteur/$mois");
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors de la mise à jour.";
            $this->redirect('/ficheFrais');
        }
    }

    public function delete($idVisiteur, $mois): void
    {
        if (empty($_SESSION['uid'])) $this->redirect('/');

        $idVisiteur = (int)$idVisiteur;
        $mois       = (int)$mois;

        try {
            $ok = FicheFrais::delete($idVisiteur, $mois);
            $_SESSION['flash'] = $ok ? "Fiche supprimée." : "Impossible de supprimer.";
        } catch (\Throwable $e) {
            $_SESSION['flash'] = "Erreur lors de la suppression.";
        }

        $this->redirect('/ficheFrais');
    }
}
