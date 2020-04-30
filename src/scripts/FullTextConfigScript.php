<?php


namespace WebDevEtc\BlogEtc\scripts;

//Composer script

class FullTextConfigScript
{
    public static function postUpdate()
    {
         FullTextConfigScript::persist_config(['laravel-fulltext.exclude_records_column_name'=>'is_published']);
    }

    public static function postInstall()
    {
        FullTextConfigScript::persist_config(['laravel-fulltext.exclude_records_column_name'=>'is_published']);
    }

    public static function set_deep_index_value(&$data,$data_indexes,$new_value){
        foreach ($data_indexes as $index){
            if($index == sizeof($data_indexes)-1)  $data[$index]=$new_value;
            else return FullTextConfigScript::set_deep_index_value($data[$index],array_slice($data_indexes,1),$new_value);
        }
    }

    public static function persist_config($target,$new_value = null) {
        if(is_array($target) && sizeof($target) == 1){
            $new_value = array_values($target)[0];
            $target = array_keys($target)[0];
        }
        $array = explode('.',$target);
        $filename = app()->getConfigurationPath().$array[0].'.php';
        $data_indexes = array_slice($array,1);

        $data = config($array[0]);
        FullTextConfigScript::set_deep_index_value($data,$data_indexes,$new_value);

        file_put_contents($filename,"<?php\n return ".var_export($data,1)." ;");
        \Illuminate\Support\Facades\Artisan::call('cache:clear');
    }
}