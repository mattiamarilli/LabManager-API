<?php
/**
 * Created by 2000AndreaPaolo <2000.andrea.paolo@gmail.com>
 * 29/03/19
 */

class AuthController {
  static function studentLogin($req, $res, $service, $app){
    $parameters = $req->body();
    $parameters = json_decode($parameters, true);
    $stm = $app->db->prepare('SELECT s.id_studente, s.nome, s.cognome, s.id_classe, s.id_gruppo, c.nome FROM studente s INNER JOIN classe c ON s.id_classe=c.id_classe WHERE s.username = :username and s.password = :password');
    $stm->bindValue(":username", $parameters['username']);
    $stm->bindValue(":password", $parameters['password']);
    $stm->execute();
    if($stm->rowCount() > 0){
      $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);

      $data = array_map(function($entry){
          return [
              'id' => +$entry['id_studente'],
              'nome' => $entry['nome'],
              'cognome' => $entry['cognome'],
              'id_gruppo' => $entry['id_gruppo'] ? +$entry['id_gruppo'] : null,
              'id_classe' => +$entry['id_classe'],
              'classe' => $entry['nome']
          ];
      }, $dbres);
      $res->json($data);
    }else{
      $res->json(["message" => "Username o Password errati", "code" => 402, "uername"=> $parameters['username']]);
    }
  }

  static function teacherLogin($req, $res, $service, $app){
    $res->json(['ciao'=>'ciao']);
  }
}
