<?php
namespace Mbright\Manager;

use Spot\Locator;

class LocationManager extends AbstractManager
{
    public function __construct(Locator $locator)
    {
        $this->locator = $locator;
    }

    public function getEntityName()
    {
        return 'Mbright\Entities\Location';
    }
}