<?php

namespace AdamTorok96\LaravelSettings;


use Illuminate\Support\Facades\Storage;

class JsonSettingDriver extends SettingDriver
{
    public function save()
    {
        $this->write();
    }

    protected function write()
    {
        Storage::disk($this->getConfig('disk'))
            ->put(
                $this->getPath(),
                json_encode($this->data)
            )
        ;
    }

    protected function read()
    {
        $this->data = Storage::disk($this->getConfig('disk'))->exists($this->getPath())
            ? json_decode(
                Storage::disk($this->getConfig('disk'))->get($this->getPath()),
                true)
            : []
        ;
    }

    private function getPath()
    {
        return implode('/', [
            $this->getConfig('dir'),
            $this->getConfig('file')
        ]);
    }

    private function getConfig(string $key)
    {
        return $this->config['json'][$key];
    }
}