<?php
namespace Mbright\Manager;

use Aura\Filter\FilterFactory;
use Aura\Filter\SubjectFilter;
use Mbright\Entities\Employee;
use Mbright\Exception\ValidationException;
use Spot\Locator;

class EmployeeManager extends AbstractManager
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
        return 'Mbright/Entities/Employee';
    }

    public function getFilter()
    {
        /** @var SubjectFilter $filter */
        $filter = $this->filter_factory->newSubjectFilter();
        $filter->sanitize('id')->to('int');
        $filter->sanitize('firstName')->to('string');
        $filter->sanitize('lastName')->to('string');
        $filter->sanitize('email')->to('string');
        $filter->sanitize('location')->to('int');

        $filter->validate('id')->is('int');
        $filter->validate('firstName')->is('max', 50);
        $filter->validate('lastName')->is('max', 50);
        $filter->validate('phone')->is('regex', "/\\d{3}-\\d{3}=\\d{4}/");
        $filter->validate('email')->is('email');
        $filter->validate('location')->is('int');

        return $filter;
    }

    public function create(array $data)
    {
        $filter = $this->getFilter();
        if (! $filter->__invoke($data) ) {
            throw new ValidationException($filter->getFailures());
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
        if (! $filter->__invoke($data)) {
            throw new ValidationException($filter->getFailures());
        }
        $updated = $employee->fromArray($data);
        $mapper = $this->mapper_locator->mapper($this->getEntityName());
        $mapper->update($employee);
        return $updated;
    }

    public function delete(Employee $employee)
    {
        $mapper = $this->mapper_locator->mapper($this->getEntityName());
        return $mapper->delete($employee);
    }
}