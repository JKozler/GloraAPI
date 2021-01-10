<?php

// Namespace
namespace App\Presenters;

// Usingy
use Nette;
use Nette\Application\LinkGenerator;
use Nette\Application\Responses\JsonResponse;
use Nette\Utils\Finder;
use Nette\Utils\Json;

final class ApiPresenter extends Nette\Application\UI\Presenter
{
    private $database;
    private $httpRequest;

    function __construct(Nette\Database\Context $database, Nette\Http\Request $httpRequest) {
        // Inicializace vnitřního stavu objektu
        $this->database = $database;
        $this->httpRequest = $httpRequest;
    }

    public function actionGetNumberOfUser($id) {
        // Získá cestu k modelovému adresáři
        $data = $this->database->query('SELECT COUNT(*) FROM users WHERE team=?', $id)->fetch();
        // Vrátí výsledek
        $this->sendResponse(new JsonResponse($data));
    }

    public function actionGetUser($id) {
        // Získá cestu k modelovému adresáři
        $dataUser = $this->database->table('users')->where('id=?',$id)->fetch();
        // Vrátí výsledek
        $this->sendResponse(new JsonResponse(['name' => $dataUser->name, 'email' => $dataUser->email, 'team' => $dataUser->team]));
    }

    public function actionGetTeam($id) {
        // Získá cestu k modelovému adresáři
        $dataTeam = $this->database->table('teams')->where('id=?', $id)->fetch();
        // Vrátí výsledek
        $this->sendResponse(new JsonResponse(['name' => $dataTeam->name, 'code' => $dataTeam->code, 'isSolved' => $dataTeam->isSolved]));
    }

    public function actionUserIdByName($id) {
        // Získá cestu k modelovému adresáři
        $dataTeam = $this->database->table('users')->where('name=?', $id)->fetch();
        // Vrátí výsledek
        $this->sendResponse(new JsonResponse(['id' => $dataTeam->id]));
    }

    public function actionGetTaskDetail($id) {
        // Získá cestu k modelovému adresáři
        $data = $this->database->query('SELECT * FROM task WHERE userId=?', $id)->fetchAll();
        // Vrátí výsledek
        $this->sendResponse(new JsonResponse(['task' => $data]));
    }

    public function actionGetTeamDetail($id) {
        // Získá cestu k modelovému adresáři
        $data = $this->database->query('SELECT * FROM teams WHERE code=?', $id)->fetch();
        // Vrátí výsledek
        $this->sendResponse(new JsonResponse(['name' => $data->name, 'code' => $data->code, 'isSolved' => $data->isSolved, 'id' => $data->id]));
    }

    public function actionGetUserDetail($id) {
        $all = Json::decode($id);
        // Získá cestu k modelovému adresáři
        $data = $this->database->query('SELECT * FROM users WHERE name=? and password=?', $all->name, $all->password)->fetch();
        // Vrátí výsledek
        $this->sendResponse(new JsonResponse(['user' => $data]));
    }

    public function actionGetAllUsersFromTeam($id) {
        // Získá cestu k modelovému adresáři
        $data = $this->database->query('SELECT name FROM users WHERE team=?', $id)->fetchAll();
        // Vrátí výsledek
        $this->sendResponse(new JsonResponse(['users' => $data]));
    }

    public function actionGetTask($id) {
        // Získá cestu k modelovému adresáři
        $dataTeam = $this->database->table('task')->where('teamCode=?', $id)->fetch();
        // Vrátí výsledek
        $this->sendResponse(new JsonResponse(['teamCode' => $dataTeam->teamCode, 'state' => $dataTeam->state, 'name' => $dataTeam->name, 'description' => $dataTeam->description, 'userId' => $dataTeam->userId, 'dateFrom' => $dataTeam->dateFrom, 'dateTo' => $dataTeam->dateTo]));
    }

    public function actionPostUser($id) {
        // Získá cestu k modelovému adresáři
        $all = Json::decode($id);
        try {
            $this->database->query('INSERT INTO users', [
                'name' => $all->name,
                'email' => $all->email,
                'password' => $all->password,
                'team' => $all->teamId,
                'time' => $all->time
            ]);
            // Vrátí vloženou hodnotu
            $this->sendResponse(new JsonResponse(['user' => $all]));
        } catch (Exception $e) {
            
        }
    }

    public function actionPostTeam($id) {
        // Získá cestu k modelovému adresáři
        $all = Json::decode($id);
        $this->database->query('INSERT INTO teams', [
            'code' => substr(md5(uniqid(mt_rand(), true)) , 0, 8),
            'name' => $all->name,
            'isSolved' => $all->isSolved,
        ]);
        // Vrátí vloženou hodnotu
        $this->sendResponse(new JsonResponse($all));
    }

    public function actionPostTask($id) {
        // Získá cestu k modelovému adresáři
        $all = Json::decode($id);
        $this->database->query('INSERT INTO task', [
            'teamCode' => $all->teamCode,
            'name' => $all->name,
            'description' => $all->description,
            'userId' => $all->userId,
            'dateFrom' => $all->dateFrom,
            'dateTo' => $all->dateTo,
            'state' => $all->state,
        ]);
        // Vrátí vloženou hodnotu
        $this->sendResponse(new JsonResponse($all));
    }

    public function actionPutUser($id) {
        // Získá cestu k modelovému adresáři
        $all = Json::decode($id);
        $this->database->query('UPDATE users SET', [
            'name' => $all->name,
            'email' => $all->email,
            'password' => $all->password,
            'team' => $all->team,
            'time' => $all->time
        ], 'WHERE name=? and password=?', $all->name, $all->password);
        // Vrátí vloženou hodnotu
        $this->sendResponse(new JsonResponse($all));
    }

    public function actionPutTeam($id) {
        // Získá cestu k modelovému adresáři
        $all = Json::decode($id);
        $this->database->query('UPDATE teams SET', [
            'name' => $all->name,
            'isSolved' => $all->isSolved,
        ], 'WHERE id = ?', $all->id);
        // Vrátí vloženou hodnotu
        $this->sendResponse(new JsonResponse($all));
    }

    public function actionPutTask($id) {
        // Získá cestu k modelovému adresáři
        $all = Json::decode($id);
        $this->database->query('UPDATE task SET', [
            'name' => $all->name,
            'description' => $all->description,
            'userId' => $all->userId,
            'dateFrom' => $all->dateFrom,
            'dateTo' => $all->dateTo,
            'state' => $all->state,
        ], 'WHERE id = ?', $all->id);
        // Vrátí vloženou hodnotu
        $this->sendResponse(new JsonResponse($all));
    }
}