<?php
namespace Mbright\Entities;

use Spot\Entity;

class Location extends Entity
{
    protected static $table ='locations';

    public static function fields()
    {
        return [
            'id'    => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'name'  => ['type' => 'string', 'length' => 50]
        ];
    }
}