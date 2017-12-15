<?php

namespace App\Model;

use Core\Base\Model;
use Core\DB\DB;

class ArticleModel extends Model
{

    protected $table = "articles";

    public function all()
    {
        $sql = sprintf("SELECT * FROM `%s`", $this->table);
        $sth = DB::pdo()->prepare($sql);
        $sth->execute();

        return $sth->fetchAll();

    }

}