<?php
/**
 * Created by 2000AndreaPaolo <2000.andrea.paolo@gmail.com>
 * 20/04/19
 */

class TeacherController{

  // GET /admin/docente
  static function getTeachers($req, $res, $service, $app){
    $stm = $app->db->prepare('SELECT id_docente, nome, cognome, username FROM docente');
    $stm->execute();
    $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);
    $res->json($dbres);
  }

  // POST /admin/docente
  static function addTeacher($req, $res, $service, $app){
      $parameters = $req->body();
      $parameters = json_decode($parameters, true);
      $password = self::generateRandomPassword();
      $username = $parameters['nome'] . "." . $parameters['cognome']; //username nel formato "nome.cognome"
      $stm = $app->db->prepare('INSERT INTO docente (nome, cognome, username, password, admin) VALUES (:nome, :cognome, :username, :password, :admin)');
      $stm->bindValue(":nome", $parameters['nome']);
      $stm->bindValue(":cognome", $parameters['cognome']);
      $stm->bindValue(":username", $username);
      $stm->bindValue(":password", $password);
      $stm->bindValue(":admin", 0);
      if($stm->execute()){
        $res->json(["message" => "OK", "code" => 200 ]);
      }
      else{
        $res->json(["message" => "Docente non aggiunto", "code" => 500 ]);
      }
  }

  //Genera stringa alfanumerica random
	function generateRandomPassword($length = 10) {
		return substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length/strlen($x)) )),1,$length);
	}

  //PUT /admin/docente
  static function modifyTeacher($req, $res, $service, $app){
      $parameters = $req->body();
      $parameters = json_decode($parameters, true);
      $username = $parameters['nome'] . "." . $parameters['cognome'];
      $stm = $app->db->prepare('UPDATE docente SET nome = :nome, cognome = :cognome, username = :username WHERE id_docente = :id_docente');
      $stm->bindValue(":nome", $parameters['nome']);
      $stm->bindValue(":cognome", $parameters['cognome']);
      $stm->bindValue(":username", $username);
      $stm->bindValue(":id_docente", $parameters['id_docente']);
      $stm->execute();
      if($stm->rowCount() > 0){
          $res->json(["message" => "OK", "code" => 200 ]);
      }else{
          $res->json(["message" => "Docente non modificato", "code" => 500 ]);
      }
  }

  //DELETE /admin/docente
  static function deleteTeacher($req, $res, $service, $app){
      $parameters = $req->body();
      $parameters = json_decode($parameters, true);
      $stm = $app->db->prepare('DELETE FROM docente WHERE id_docente=:id_docente');
      $stm->bindValue(":id_docente", $parameters['id_docente']);
      $stm->execute();
      if($stm->rowCount() > 0){
        $res->json(["message" => "OK", "code" => 200 ]);
      }else{
        $res->json(["message" => "Docente non eliminato", "code" => 500 ]);
      }
  }
}
