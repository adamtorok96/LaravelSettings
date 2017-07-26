<?php

namespace AdamTorok96\LaravelSettings;


abstract class SettingDriver
{
    /**
     * @var $data array
     */
    protected $data = [];

    public function __construct()
    {
        $this->read();
    }

    public function all()
    {
        return $this->data;
    }

    public function set($key, $value = null) {
        $this->data[$key] = $value;
    }

    public function get($key)
    {
        return isset($this->data[$key]) ? $this->data[$key] : null;
    }

    public function has($key)
    {
        return isset($this->data[$key]);
    }

    public function delete($key)
    {
        unset($this->data[$key]);
    }

    abstract public function save();

    abstract protected function write();

    abstract protected function read();
}