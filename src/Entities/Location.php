<?php
namespace Mbright\Entities;

use Spot\Entity;

class Location extends Entity
{
    protected static $table ='locations';

    protected $id;

    protected $name;

    public static function fields()
    {
        return [
            'id'    => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'name'  => ['type' => 'string', 'length' => 50]
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id)
    {
        $this->id = $id;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
}