<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Entity extends Model
{
    public static function getTableName()
    {
        return with(new static)->getTable();
    }
}
