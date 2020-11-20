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
        $obj = HessamConfiguration::where('key', $key)->first();
        if ($obj){
            return $obj->value;
        }
        else{
            return null;
        }
    }

    public static function set($key, $value){
        $config = new HessamConfiguration();
        $config->key = $key;
        $config->value = $value;
        $config->save();
    }
}
