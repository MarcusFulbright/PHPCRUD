<?php
namespace Mbright\Entities;

use Mbright\Traits\FromArray;
use Mbright\Traits\ToArray;
use Spot\Entity;
use Spot\EntityInterface;
use Spot\MapperInterface;

class Employee extends Entity
{
    use ToArray;

    use FromArray;

    protected static $table ='employees';

    protected $id;

    protected $firstName;

    protected $lastName;

    protected $phone;

    protected $email;

    protected $location;

    public static function fields()
    {
        return [
            'id'        => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'firstName' => ['type' => 'string', 'required' => true, 'length' => 50],
            'lastName'  => ['type' => 'text', 'required' => true, 'length' => 50],
            'phone'     => ['type' => 'integer', 'default' => 0, 'index' => true, 'length' => 25],
            'email'     => ['type' => 'string', 'required' => true],
            'location'  => ['type' => 'integer', 'required' => true]
        ];
    }

    public static function relations (MapperInterface $mapper, EntityInterface $entity)
    {
        return [
            $mapper->belongsTo($entity, 'Mbright\Entities\Location', 'location')
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

    public function getFirstName()
    {
        return $this->firstName;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;
    }

    public function getLastName()
    {
        return $this->lastName;
    }

    public function setLastName($lastName)
    {
        $this->lastName = $lastName;
    }

    public function getPhone()
    {
        return $this->phone;
    }

    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation($location)
    {
        $this->location = $location;
    }
}