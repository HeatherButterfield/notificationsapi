<?php
require_once 'AppService.php';
class TeamService extends AppService
{
    function __construct($dbconfig, $request){
        parent::__construct($dbconfig, $request);
    }

    public function list() {
        $sql = "select * FROM teams";
        try {
            $stmt = $this->dbcon->query($sql);
            $wines = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;

            return json_encode($wines);
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function read() {
        $id = $this->request->getAttribute('id');
        $sql = "SELECT * FROM teams WHERE id=$id";
        try {
            $stmt = $this->dbcon->query($sql);
            $wines = $stmt->fetchAll(PDO::FETCH_OBJ);
            $db = null;

            return json_encode($wines);
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function create() {
        $team = json_decode($this->request->getBody());

        $sql = "INSERT INTO teams (id, name, league, coach, admin, phone, players) VALUES (:id, :name, :league, :coach, :admin, :phone, :players)";
        try {
            $db = $this->dbcon;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $team->id);
            $team->id = $this->sanitize($team->id);
            $stmt->bindParam("name", $team->name);
            $team->name = $this->sanitize($team->name);
            $nameError = $this->required($team->name, "name");
            $stmt->bindParam("league", $team->league);
            $team->league = $this->sanitize($team->league);
            $stmt->bindParam("coach", $team->coach);
            $team->coach = $this->sanitize($team->coach);
            $stmt->bindParam("admin", $team->admin);
            $team->admin = $this->sanitize($team->admin);
            $stmt->bindParam("phone", $team->phone);
            $team->phone = $this->sanitize($team->phone);
            $phoneError = $this->validatePhone($team->phone);
            $stmt->bindParam("players", $team->players);
            $team->players = $this->sanitize($team->players);
            if (!$nameError && !$phoneError) {
                $stmt->execute();
                $db = null;
                echo json_encode($team);
            }
            if ($nameError) {
                echo $nameError;
            }  
            if ($phoneError) {
                echo $phoneError;
            }
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function update() {
        $team = json_decode($this->request->getBody());
        $id = $this->request->getAttribute('id');
        $sql = "UPDATE teams SET name=:name, league=:league, coach=:coach, admin=:admin, phone=:phone, players=:players WHERE id=:id";
        try {
            $db = $this->dbcon;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->bindParam("name", $team->name);
            $team->name = $this->sanitize($team->name);
            $nameError = $this->required($team->name, "name");
            $stmt->bindParam("league", $team->league);
            $team->league = $this->sanitize($team->league);
            $stmt->bindParam("coach", $team->coach);
            $team->coach = $this->sanitize($team->coach);
            $stmt->bindParam("admin", $team->admin);
            $team->admin = $this->sanitize($team->admin);
            $stmt->bindParam("phone", $team->phone);
            $team->phone = $this->sanitize($team->phone);
            $phoneError = $this->validatePhone($team->phone);
            $stmt->bindParam("players", $team->players);
            $team->players = $this->sanitize($team->players);
            if (!$nameError && !$phoneError) {
                $stmt->execute();
                $db = null;
                echo json_encode($team);
            }
            if ($nameError) {
                echo $nameError;
            }  
            if ($phoneError) {
                echo $phoneError;
            }
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }

    function delete() {
        $id = $this->request->getAttribute('id');
        $sql = "DELETE FROM teams WHERE id=:id";
        try {
            $db = $this->dbcon;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $db = null;
            echo '{"error":{"text":"successfully! deleted Team"}}';
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
}
