<?php
    namespace Mbright\Entities;

    use Spot\Entity;
    use Spot\EntityInterface;
    use Spot\MapperInterface;

    class Employee extends Entity
    {
        protected static $table ='employees';

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
    }