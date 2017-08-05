<?php

namespace AdamTorok96\LaravelSettings;


use Illuminate\Database\Eloquent\Model;

class MysqlSettingRecord extends Model
{
    protected $table = 'setting_records';

    protected $primaryKey = 'key';

    protected $keyType = 'string';

    protected $fillable = [
        'key', 'type', 'value'
    ];

    public $timestamps = false;
}