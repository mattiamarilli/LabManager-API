<?php
/**
 * Created by 2000AndreaPaolo <2000.andrea.paolo@gmail.com>
 * 29/03/19
 */

class AuthController {
  static function studentLogin($req, $res, $service, $app){
    $parameters = $req->body();
    $parameters = json_decode($parameters, true);
    $stm = $app->db->prepare('SELECT id_studente, nome, cognome, id_classe, id_gruppo FROM studente WHERE username = :username and password = :password');
    $stm->bindValue(":username", $parameters['username']);
    $stm->bindValue(":password", $parameters['password']);
    $stm->execute();
    if($stm->rowCount() > 0){
      $dbres = $stm->fetchAll(PDO::FETCH_ASSOC);
      $stm = $app->db->prepare('SELECT nome FROM classe where id_classe=:id_classe AND abilita=true');
      $stm->bindValue(":id_classe", $parameters['id_classe']);
      $stm->execute();
      if($stm->rowCount() > 0){
        $dbres2 = $stm->fetchAll(PDO::FETCH_ASSOC);
        $data = array_map(function($entry, $dbres2){
            return [
                'id' => +$entry['id_studente'],
                'nome' => $entry['nome'],
                'cognome' => $entry['cognome'],
                'id_gruppo' => $entry['id_gruppo'] ? +$entry['id_gruppo'] : null,
                'id_classe' => +$entry['id_classe'],
                'classe' => $dbres2['nome']
            ];
        }, $dbres);
        $res->json($data);
      }else{
        $res->json(["message" => "Classe non in labratorio", "code" => 402]);
      }
    }else{
      $res->json(["message" => "Username o Password errati", "code" => 402, "uername"=> $parameters['username']]);
    }
  }

  static function teacherLogin($req, $res, $service, $app){
    $res->json(['ciao'=>'ciao']);
  }
}
