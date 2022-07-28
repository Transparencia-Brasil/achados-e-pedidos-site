<?php

namespace App\Tasks;

class TaskEnvHelper {
    private $currentTaskId;
    private $currentStatusProgress;
    private $dataFile;

    public function Init($taskId) {
        $this->currentTaskId = $taskId;
        $this->currentStatusProgress = array(
            "Percent" => 0,
            "Message" => "Iniciando"
        );
        $this->dataFile = TMP . "/" . $this->currentTaskId . ".info";
        $this->load();
    }

    public function setProgress($message, $percent) {
        if(is_null($this->currentTaskId)) {
            return;
        }

        $this->currentStatusProgress["Percent"] = $percent;
        $this->currentStatusProgress["Message"] = $message;

        $this->save();
    }

    public function setProgressFrom($message, $from, $to) {
        $percent = ($from / $to) * 100;
        $this->setProgress($message, $percent);
    }

    public function getPercent() {
        if(is_null($this->currentTaskId)) {
            return 0;
        }

        return $this->currentStatusProgress["Percent"];
    }

    public function getMessage() {
        if(is_null($this->currentTaskId)) {
            return "Desconhecido";
        }

        return $this->currentStatusProgress["Message"];
    }

    public function save() {
        file_put_contents($this->dataFile, json_encode($this->currentStatusProgress));
    }

    public function load() {
        if(file_exists($this->dataFile)) {
            $this->currentStatusProgress = json_decode(file_get_contents($this->dataFile));
        }
    }

    private static $INSTANCE = null;
    public static function getInstance() {
        if(self::$INSTANCE == null) {
            self::$INSTANCE = new TaskEnvHelper();
        }

        return self::$INSTANCE;
    }
}



?>

