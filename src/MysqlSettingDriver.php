<?php

namespace AdamTorok96\LaravelSettings;


use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Database\MySqlConnection;
use Illuminate\Support\Str;

class MysqlSettingDriver extends SettingDriver
{
    /**
     * @var $connection MySqlConnection
     */
    protected $connection;

    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    protected function write()
    {
       foreach ($this->data as $key => $value) {
           MysqlSettingRecord::updateOrCreate([
               'key'    => $key
           ], [
               'type'   => $this->getType($value),
               'value'  => $value
           ]);
       }
    }

    protected function read()
    {
        foreach (MysqlSettingRecord::all() as $setting) {
            $method = 'get' . Str::studly($setting->type) . 'Value';

            if( !method_exists($this, $method) )
                throw new Exception($setting->type . ' not supported');

            $this->data[$setting->key] = $this->$method($setting->value);
        }
    }

    public function delete(string $key)
    {
        parent::delete($key);

        $record = MysqlSettingRecord::whereKey($key);

        if( $record->exists() ) {
            $record->first()->delete();
        }
    }

    protected function getType($value)
    {
        if( is_array($value) )
            throw new Exception('Array is a not supported type!');

        if( !is_object($value) )
            return gettype($value);

        if( $value instanceof DateTime )
            return 'datetime';

        if( $value instanceof Carbon )
            return 'carbon';

        throw new Exception(get_class($value) .' is not a supported object!');
    }

    protected function getBooleanValue(string $value)
    {
        return boolval($value);
    }

    protected function getIntegerValue(string $value)
    {
        return intval($value);
    }

    protected function getDoubleValue(string $value)
    {
        return doubleval($value);
    }

    protected function getFloatValue(string $value)
    {
        return floatval($value);
    }

    protected function getStringValue(string $value = null)
    {
        return $value;
    }

    protected function getNullValue(string $value = null)
    {
        return null;
    }

    protected function getDatetimeValue(string $value)
    {
        return new DateTime($value);
    }

    protected function getCarbonValue(string $value)
    {
        return Carbon::parse($value);
    }
}