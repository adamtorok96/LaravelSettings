<?php

namespace AdamTorok96\LaravelSettings;


use Carbon\Carbon;
use DateTime;
use Exception;
use Illuminate\Support\Str;

class MysqlSettingDriver extends SettingDriver
{
    /**
     * MysqlSettingDriver constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     *
     */
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

    /**
     * @throws Exception
     */
    protected function read()
    {
        foreach (MysqlSettingRecord::all() as $setting) {
            $method = 'get' . Str::studly($setting->type) . 'Value';

            if( !method_exists($this, $method) )
                throw new Exception($setting->type . ' not supported');

            $this->data[$setting->key] = $this->$method($setting->value);
        }
    }

    /**
     * @param string $key
     */
    public function delete(string $key)
    {
        parent::delete($key);

        $record = MysqlSettingRecord::whereKey($key);

        if( $record->exists() ) {
            $record->first()->delete();
        }
    }

    /**
     * @param $value
     * @return string
     * @throws Exception
     */
    protected function getType($value)
    {
        if( is_array($value) )
            throw new Exception('Array type is not supported!');

        if( !is_object($value) )
            return gettype($value);

        if( $value instanceof DateTime )
            return 'datetime';

        if( $value instanceof Carbon )
            return 'carbon';

        throw new Exception(get_class($value) .' is not a supported object!');
    }

    /**
     * @param string $value
     * @return bool
     */
    protected function getBooleanValue(string $value)
    {
        return boolval($value);
    }

    /**
     * @param string $value
     * @return int
     */
    protected function getIntegerValue(string $value)
    {
        return intval($value);
    }

    /**
     * @param string $value
     * @return float
     */
    protected function getDoubleValue(string $value)
    {
        return doubleval($value);
    }

    /**
     * @param string $value
     * @return float
     */
    protected function getFloatValue(string $value)
    {
        return floatval($value);
    }

    /**
     * @param string|null $value
     * @return string
     */
    protected function getStringValue(string $value = null)
    {
        return $value;
    }

    /**
     * @param string|null $value
     * @return null
     */
    protected function getNullValue(string $value = null)
    {
        return null;
    }

    /**
     * @param string $value
     * @return DateTime
     */
    protected function getDatetimeValue(string $value)
    {
        return new DateTime($value);
    }

    /**
     * @param string $value
     * @return static
     */
    protected function getCarbonValue(string $value)
    {
        return Carbon::parse($value);
    }
}