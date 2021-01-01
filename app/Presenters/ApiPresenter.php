<?php

// Namespace
namespace App\Presenters;

// Usingy
use Nette;
use Nette\Application\LinkGenerator;
use Nette\Application\Responses\JsonResponse;
use Nette\Utils\Finder;
use Nette\Utils\Json;
use Nette\Utils\Array;

final class ApiPresenter extends Nette\Application\UI\Presenter
{
    private $database;
    private $httpRequest;

    function __construct(Nette\Database\Context $database, Nette\Http\Request $httpRequest) {
        // Inicializace vnitřního stavu objektu
        $this->database = $database;
        $this->httpRequest = $httpRequest;
    }

    public function actionGetUser($id) {
        // Získá cestu k modelovému adresáři
        $dataUser = $this->database->table('users')->where('id=?',$id)->fetch();
        // Vrátí výsledek
        $this->sendResponse(new JsonResponse(['nameUser' => $dataUser->name, 'email' => $dataUser->email, 'teamId' => $dataUser->team]));
    }

    public function actionGetTeam($id) {
        // Získá cestu k modelovému adresáři
        $dataTeam = $this->database->table('teams')->where('id=?', $id)->fetch();
        // Vrátí výsledek
        $this->sendResponse(new JsonResponse(['nameTeam' => $dataTeam->name, 'code' => $dataTeam->code, 'isSolved' => $dataTeam->isSolved]));
    }

    public function actionPostUser($id) {
        // Získá cestu k modelovému adresáři
        $all = Json::decode($id);
        $this->database->query('INSERT INTO users', [
            'name' => $all->nameUser,
            'email' => $all->email,
            'password' => $all->password,
            'team' => $all->teamId
        ]);
        // Vrátí vloženou hodnotu
        $this->sendResponse(new JsonResponse($all));
    }
}