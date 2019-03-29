<?php
/**
 * Created by vivedo <edoardo.viviani@gmail.com>
 * 29/03/19
 */

class StudentController {

    // GET /admin/studente
    static function getStudents($req, $res, $service, $app){

        $stm = $app->db->prepare('SELECT id_studente, studente.nome, cognome, username, classe.id_classe, classe.nome AS classe, id_gruppo FROM studente INNER JOIN classe ON classe.id_classe = studente.id_classe');
        $stm->execute();
        $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);

        $data = array_map(function($entry){
            return [
                'id' => +$entry['id_studente'],
                'nome' => $entry['nome'],
                'cognome' => $entry['cognome'],
                'username' => $entry['username'],
                'id_gruppo' => $entry['id_gruppo'] ? +$entry['id_gruppo'] : null,
                'id_classe' => +$entry['id_classe'],
                'classe' => $entry['classe']
            ];
        }, $dbres);

        $res->json($data);

    }

    // POST /admin/studente
    static function addStudent($req, $res, $service, $app){

        $res->json([]);

    }

}