<?php

class MapModel
{
    private $conn;

    public function __construct()
    {
        include_once (__DIR__ . '/../../Config/config.php');

        $this->conn = $conn;

        if ($this->conn->connect_error) {
            die('Connessione fallita: ' . $this->conn->connect_error);
        }
    }

    // Crea un nuovo utente
    public function createMap($nome, $descrizione, $avatarPath)
    {
        // Inserisci i dati della mappa nel database
        $sql = "INSERT INTO Maps (name, description, image, happiness) VALUES ('$nome', '$descrizione', '$avatarPath', '0')";
        $res = $this->conn->query($sql);

        if (!$res) {
            echo 'Errore nel salvataggio della mappa: ' . $this->conn->error;
            return false;
        }

        return true;
    }

    // Recupera un elenco di mappe
    public function getMaps()
    {
        $sql = 'SELECT * FROM Maps m LEFT JOIN (SELECT Dmap_id, COUNT(*)  as totalUsers FROM Departments GROUP BY Dmap_id) d ON d.Dmap_id = m.id
                LEFT JOIN (SELECT Cmap_id, COUNT(*) as clickCount FROM MapClicks GROUP BY Cmap_id) mc ON mc.Cmap_id = m.id ORDER BY m.happiness DESC;';
        $result = $this->conn->query($sql);
        $maps = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $maps[] = $row;
            }
        }

        return json_encode($maps);
    }
}