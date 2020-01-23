<?php
require_once 'AppService.php';
class PlayerService extends AppService
{
    function __construct($dbconfig, $request){
        parent::__construct($dbconfig, $request);
    }

    function list() {
        $sql = "select * FROM players";
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
        $sql = "SELECT * FROM players WHERE id=$id";
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

        $sql = "INSERT INTO players (id, name, team, phone, age) VALUES (:id, :name, :team, :phone, :age)";
        try {
            $db = $this->dbcon;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $team->id);
            $team->id = $this->sanitize($team->id);
            $stmt->bindParam("name", $team->name);
            $team->name = $this->sanitize($team->name);
            $nameError = $this->required($team->name, "name");
            $stmt->bindParam("team", $team->team);
            $team->team = $this->sanitize($team->team);
            $stmt->bindParam("phone", $team->phone);
            $team->phone = $this->sanitize($team->phone);
            $phoneError = $this->required($team->phone, "phone");
            $phoneError = $this->validatePhone($team->phone);
            $stmt->bindParam("age", $team->age);
            $team->age = $this->sanitize($team->age);
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
        $sql = "UPDATE players SET name=:name, team=:team, phone=:phone, age=:age WHERE id=:id";
        try {
            $db = $this->dbcon;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->bindParam("name", $team->name);
            $team->name = $this->sanitize($team->name);
            $nameError = $this->required($team->name, "name");
            $stmt->bindParam("team", $team->team);
            $team->team = $this->sanitize($team->team);
            $stmt->bindParam("phone", $team->phone);
            $team->phone = $this->sanitize($team->phone);
            $phoneError = $this->required($team->phone, "phone");
            $phoneError = $this->validatePhone($team->phone);
            $stmt->bindParam("age", $team->age);
            $team->age = $this->sanitize($team->age);
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
        $sql = "DELETE FROM players WHERE id=:id";
        try {
            $db = $this->dbcon;
            $stmt = $db->prepare($sql);
            $stmt->bindParam("id", $id);
            $stmt->execute();
            $db = null;
            echo '{"error":{"text":"successfully! deleted Player"}}';
        } catch(PDOException $e) {
            echo '{"error":{"text":'. $e->getMessage() .'}}';
        }
    }
}
