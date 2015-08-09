<?php
    namespace Mbright\Test\Manager;

    use Mbright\Entities\Employee;
    use Mbright\Manager\EmployeeManager;
    use Mockery\MockInterface;

    class EmployeeManagerTest extends \PHPUnit_Framework_TestCase
    {
        /** @var MockInterface */
        protected $filter_factory;

        /** @var  MockInterface */
        protected $mapper_locator;

        /** @var  MockInterface */
        protected $mapper;

        /** @var MockInterface */
        protected $filter;

        /** @var EmployeeManager */
        protected $manager;

        /** @var string  */
        protected $entity_name = 'Mbright\Entities\Employee';

        public function setUp ()
        {
            $this->filter_factory = \Mockery::mock ('Aura\Filter\FilterFactory');
            $this->mapper_locator = \Mockery::mock ('Spot\Locator');
            $this->mapper = \Mockery::mock ('Spot\Mapper');
            $this->filter = \Mockery::mock ('Aura\Filter\Filter');
            $this->manager = new EmployeeManager($this->filter_factory, $this->mapper_locator);
        }

        public function tearDown()
        {
            \Mockery::close();
        }

        public function testGetFilter()
        {
            $this->filter_factory->shouldReceive('newSubjectFilter')->andReturn($this->filter);
            $this->filter->shouldReceive('sanitize->to')->times(5);
            $this->filter->shouldReceive('validate->is')->times(6);
            $actual = $this->manager->getFilter();
            $expected = $this->filter;
            $this->assertEquals($expected, $actual);
        }

        public function testGetAll()
        {
            $this->mapper_locator->shouldReceive('mapper')->with($this->entity_name)->andReturn($this->mapper);
            $expected = 'Returned All';
            $this->mapper->shouldReceive('all')->withNoArgs()->andReturn($expected);
            $actual = $this->manager->get();
            $this->assertEquals($expected, $actual);
        }

        public function testGetByKey()
        {
            $this->mapper_locator->shouldReceive('mapper')->with($this->entity_name)->andReturn($this->mapper);
            $expected = 'Return One';
            $primary_key = 1;
            $this->mapper->shouldReceive('get')->with($primary_key)->andReturn($expected);
            $actual = $this->manager->get($primary_key);
            $this->assertEquals($expected, $actual);
        }

        public function testCreate()
        {
            $data = [
                'firstName' => 'John',
                'lastName'  => 'Wick',
                'phone'     => '555-555-5555',
                'email'     => 'jon.wick@gmail.com',
                'location'  => 1
            ];

            $this->filter_factory->shouldReceive('newSubjectFilter')->andReturn($this->filter);
            $this->filter->shouldReceive('sanitize->to');
            $this->filter->shouldReceive('validate->is');
            $this->filter->shouldReceive('__invoke')->with($data)->andReturn(true);
            $this->mapper_locator->shouldReceive('mapper')->with($this->entity_name)->andReturn($this->mapper);
            $this->mapper->shouldReceive('insert');
            $actual = $this->manager->create($data);
            $this->assertInstanceOf('Mbright\Entities\Employee', $actual);
        }

        public function testUpdate()
        {
            $data =[1,2,3];
            $original = \Mockery::mock('Mbright\Entities\Employee');
            $this->filter_factory->shouldReceive('newSubjectFilter')->andReturn($this->filter);
            $this->filter->shouldReceive('sanitize->to')->times(5);
            $this->filter->shouldReceive('validate->is')->times(6);
            $this->filter->shouldReceive('__invoke')->andReturn(true);
            $original->shouldReceive('fromArray')->with($data)->andReturnSelf();
            $this->mapper_locator->shouldReceive('mapper')->with($this->entity_name)->andReturn($this->mapper);
            $this->mapper->shouldReceive('update')->with($original);
            $expected = $this->manager->update($data, $original);
            $this->assertEquals($original, $expected);
        }

        public function testDelete()
        {
            $original = \Mockery::mock('Mbright\Entities\Employee');
            $this->mapper_locator->shouldReceive('mapper')->with($this->entity_name)->andReturn($this->mapper);
            $this->mapper->shouldReceive('delete')->with($original)->andReturn(true);
            $this->assertTrue($this->manager->delete($original));
        }
    }