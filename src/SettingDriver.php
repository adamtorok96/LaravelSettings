<?php

namespace AdamTorok96\LaravelSettings;


use Illuminate\Support\Facades\Cache;

abstract class SettingDriver
{
    /**
     * @var $data array
     */
    protected $data = [];

    /**
     * @var $config array
     */
    protected $config;

    /**
     * SettingDriver constructor.
     * @param $config array
     */
    public function __construct(array $config)
    {
        $this->config = $config;
    }

    public function all()
    {
        return $this->data;
    }

    public function set(string $key, $value = null) {
        $this->data[$key] = $value;

        if( $this->hasCache()) {
            Cache::forever($this->cacheTag($key), $value);
        }
    }

    public function get(string $key, $default = null)
    {
        if( $this->hasCache() && Cache::has($this->cacheTag($key)) ) {
            return Cache::get($this->cacheTag($key));
        }

        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    public function has(string $key)
    {
        return isset($this->data[$key]);
    }

    public function delete(string $key)
    {
        unset($this->data[$key]);

        if( $this->hasCache() ) {
            Cache::forget($this->cacheTag($key));
        }
    }

    public function save()
    {
        $this->write();
    }

    public function load()
    {
        $this->read();

        if( $this->hasCache() ) {

            foreach ($this->data as $key => $value) {
                Cache::forever($this->cacheTag($key), $value);
            }

        }
    }

    abstract protected function write();

    abstract protected function read();

    private function hasCache()
    {
        return $this->config['cache'];
    }

    private function cacheTag($key)
    {
        return implode(':', [
            $this->config['cache_prefix'],
            $key
        ]);
    }
}