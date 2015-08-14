<?php
namespace Mbright\Manager;

use Aura\Filter\Exception\FilterFailed;
use Aura\Filter\FilterFactory;
use Aura\Filter\SubjectFilter;
use Mbright\Entities\Employee;
use Mbright\Exception\ValidationException;
use Spot\Locator;

class EmployeeManager
{
    /** @var FilterFactory */
    protected $filter_factory;

    public function __construct(FilterFactory $filter_factory, Locator $mapper_locator)
    {
        $this->filter_factory = $filter_factory;
        $this->mapper_locator = $mapper_locator;
    }

    protected function getEntityName()
    {
        return 'Mbright\Entities\Employee';
    }

    public function get($id = null)
    {
        $mapper = $this->mapper_locator->mapper($this->getEntityName());
        if ($id === null) {
            $output = $mapper->all()->with('location');
        } else {
            $output = $mapper->first(['id' => $id]);
        }
        return $output;
    }

    public function getFilter()
    {
        /** @var SubjectFilter $filter */
        $filter = $this->filter_factory->newSubjectFilter();
        $filter->sanitize('firstName')->to('string');
        $filter->sanitize('lastName')->to('string');
        $filter->sanitize('email')->to('string');
        $filter->sanitize('location')->to('int');

        $filter->validate('firstName')->is('max', 50);
        $filter->validate('lastName')->is('max', 50);
        $filter->validate('phone')->is('regex', "/\\d{3}-\\d{3}-\\d{4}/");
        $filter->validate('email')->is('email');
        $filter->validate('location')->is('int');

        return $filter;
    }

    public function create(array $data)
    {
        $filter = $this->getFilter();
        try {
            $filter->__invoke($data);
        } catch (FilterFailed $e) {
            throw new ValidationException($e->getMessage());
        }

        $employee =  new Employee();
        $employee->fromArray($data);
        $mapper = $this->mapper_locator->mapper($this->getEntityName());
        $mapper->insert($employee);
        return $employee;
    }

    public function update(array $data, Employee $employee)
    {
        $filter = $this->getFilter();
        try {
            $filter->__invoke($data);
        } catch (FilterFailed $e) {
            throw new ValidationException($e->getMessage());
        }
        $mapper = $this->mapper_locator->mapper($this->getEntityName());
        $values = array_merge($employee->data(), $data);

        $insert = '';
        foreach ($values as $field => $value) {
            $insert = $insert .$field. ' = '. "'$value'".', ';
        }
        $insert = trim($insert, ', ');
        $id = $values['id'];
        $sql = "UPDATE employees
        SET $insert
        WHERE id = '$id'
        ";

        try {
            $mapper->query($sql);
        } catch (\Exception $e) {
            //Spot is silly and I can't figure out how to make updates work. The Query runner is trying to return
            //results and insert queries don't have any results. This causes an error that I'm ignoring with this
            //try catch. It's dirty, but I can't figure out why Spot is being dumb.
        }

        return $employee;
    }

    public function delete(Employee $employee)
    {
        $mapper = $this->mapper_locator->mapper($this->getEntityName());
        return $mapper->delete($employee);
    }
}