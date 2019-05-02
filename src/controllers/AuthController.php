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
      $stm = $app->db->prepare('SELECT nome as nomeclasse FROM classe where id_classe=:id_classe AND abilita=true');
      $stm->bindValue(":id_classe", $dbres[0]['id_classe']);
      $stm->execute();
      if($stm->rowCount() > 0){
        $var = $stm->fetchAll(PDO::FETCH_ASSOC);
        $dbres[0]['nome_classe'] = $var[0]['nomeclasse'];
        $data = array_map(function($entry){
            return [
                'id' => +$entry['id_studente'],
                'nome' => $entry['nome'],
                'cognome' => $entry['cognome'],
                'id_gruppo' => $entry['id_gruppo'] ? +$entry['id_gruppo'] : null,
                'id_classe' => +$entry['id_classe'],
                'classe' => $entry['nome_classe']
            ];
        }, $dbres);
        $res->json($data[0]);

        $_SESSION['user'] = $data[0];
      }else{
        $res->json(["message" => "Classe non in labratorio", "code" => 403]);
      }
    }else{
      $res->json(["message" => "Username o Password errati", "code" => 401]);
    }
  }

  static function teacherLogin($req, $res, $service, $app){
    $res->json(['ciao'=>'ciao']);
  }
}
