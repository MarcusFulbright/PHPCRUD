<?php
namespace Mbright\Manager;

use Spot\Locator;

abstract class AbstractManager
{
    /** @var  Locator */
    protected $mapper_locator;

    abstract protected function getEntityName();

    public function get($id = null)
    {
        $mapper = $this->mapper_locator->mapper($this->getEntityName());
        if ($id === null) {
            $output = $mapper->all()->with('location');
        } else {
            $output = $mapper->where(['id' => $id])->with('location');
        }
        return $output;
    }
}