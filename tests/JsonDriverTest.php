<?php

namespace Tests;


use PHPUnit\Framework\TestCase;

class JsonDriverTest extends TestCase
{
    protected function getDriver($config = [])
    {
        return new \AdamTorok96\LaravelSettings\JsonSettingDriver($config);
    }
    
    public function testEmpty()
    {
        $driver = $this->getDriver();

        self::assertEquals([], $driver->all());
    }
    
    public function testSet()
    {
        $driver = $this->getDriver();
        
        $driver->set('null');
        
        self::assertEquals([
            'null' => null
        ], $driver->all());
        
        $driver->set('not_null', 'null_not');
        
        self::assertEquals([
            'null'      => null,
            'not_null'  => 'null_not'
        ], $driver->all());
    }
    
    public function testGet()
    {
        $driver = $this->getDriver();
        
        self::assertNull($driver->get('not-exists'));
        
        $driver->set('exists', 'value');
        
        self::assertEquals('value', $driver->get('exists'));
    }
    
    public function testHas()
    {
        $driver = $this->getDriver();
        
        self::assertFalse($driver->has('not-exists'));
        
        $driver->set('exists', 'value');
        
        self::assertTrue($driver->has('exists'));
    }
    
    public function testDelete()
    {
        $driver = $this->getDriver();
        
        $driver->delete('not-exists');
        
        $driver->set('exists', 'value');
        
        self::assertEquals([
            'exists' => 'value'
        ], $driver->all());
        self::assertTrue($driver->has('exists'));
        
        $driver->delete('exists');
        
        self::assertEquals([], $driver->all());
        self::assertFalse($driver->has('exists'));
    }
}