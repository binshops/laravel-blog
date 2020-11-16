<?php


namespace HessamCMS\Models;

use Illuminate\Database\Eloquent\Model;


/**
 *
 */
class HessamConfiguration extends Model
{
    public $fillable = [
        'key',
        'value'
    ];

    public static function get($key){
        return HessamConfiguration::where('key', $key)->first();
    }

    public static function set($key, $value){
        $config = new HessamConfiguration();
        $config->key = $key;
        $config->value = $value;
        $config->save();
    }
}
