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

    /**
     * @return array
     */
    public function all()
    {
        return $this->data;
    }

    /**
     * @param string $key
     * @param null $value
     */
    public function set(string $key, $value = null) {
        $this->data[$key] = $value;

        if( $this->hasCache()) {
            Cache::forever($this->cacheTag($key), $value);
        }
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get(string $key, $default = null)
    {
        if( $this->hasCache() && Cache::has($this->cacheTag($key)) ) {
            return Cache::get($this->cacheTag($key));
        }

        return isset($this->data[$key]) ? $this->data[$key] : $default;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function has(string $key)
    {
        return isset($this->data[$key]);
    }

    /**
     * @param string $key
     */
    public function delete(string $key)
    {
        unset($this->data[$key]);

        if( $this->hasCache() ) {
            Cache::forget($this->cacheTag($key));
        }
    }

    /**
     *
     */
    public function save()
    {
        $this->write();
    }

    /**
     *
     */
    public function load()
    {
        $this->read();

        if( $this->hasCache() ) {

            foreach ($this->data as $key => $value) {
                Cache::forever($this->cacheTag($key), $value);
            }

        }
    }

    /**
     * @return mixed
     */
    abstract protected function write();

    /**
     * @return mixed
     */
    abstract protected function read();

    /**
     * @return bool
     */
    private function hasCache()
    {
        return isset($this->config['cache']) && $this->config['cache'];
    }

    /**
     * @param $key
     * @return string
     */
    private function cacheTag($key)
    {
        return implode(':', [
            $this->config['cache_prefix'],
            $key
        ]);
    }
}