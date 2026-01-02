<?php
namespace App\Models\Requetes;

class Model {
    protected function query($sql, $params = [])
    {
        $stmt = BD::co()->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }
}