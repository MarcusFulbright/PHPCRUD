<?php
namespace Mbright\Manager;

use Spot\Locator;

class LocationManager
{
    public function __construct(Locator $locator)
    {
        $this->mapper_locator = $locator;
    }

    public function getEntityName()
    {
        return 'Mbright\Entities\Location';
    }

    public function get($id = null)
    {
        $mapper = $this->mapper_locator->mapper($this->getEntityName());
        if ($id === null) {
            $output = $mapper->all();
        } else {
            $output = $mapper->where(['id' => $id]);
        }
        return $output;
    }
}