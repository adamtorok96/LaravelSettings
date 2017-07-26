<?php

namespace AdamTorok96\LaravelSettings;


use Illuminate\Support\Facades\Storage;

class JsonSettingDriver extends SettingDriver
{
    /**
     * @var $config array
     */
    protected $config;

    public function __construct(array $config)
    {
        $this->config = $config;

        parent::__construct();
    }

    public function save()
    {
        $this->write();
    }

    protected function write()
    {
        Storage::disk($this->config['disk'])->put($this->getPath(), json_encode($this->data));
    }

    protected function read()
    {
        $this->data = json_decode(Storage::disk($this->config['disk'])->get($this->getPath()), true);
    }

    private function getPath()
    {
        return implode('/', [
            $this->config['dir'],
            $this->config['file']
        ]);
    }
}