<?php
namespace Mbright\Manager;

use Spot\Locator;

class LocationManager
{
    /** @var Locator */
    protected $locator;

    protected $entity_name = 'Mbright\Entities\Location';

    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    public function get($id = null)
    {
        $mapper = $this->locator->mapper($this->entity_name);
        if ($id === null) {
            $output = $mapper->all()->with('location');
        } else {
            $output = $mapper->where(['id' => $id])->with('location');
        }
        return $output;
    }
}