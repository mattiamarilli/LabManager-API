<?php
/**
 * Created by vivedo <edoardo.viviani@gmail.com>
 * 29/03/19
 */

class DummyController {

    static function get($req, $res, $service, $app){

        $app->db; // PDO

        $res->json([ ]);
    }

}