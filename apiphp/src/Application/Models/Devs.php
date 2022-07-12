<?php namespace App\Application\Models;

use \Illuminate\Database\Capsule\Manager as DB;

class Devs extends \Illuminate\Database\Eloquent\Model
{
    public $timestamps = false;
    protected $fillable = ['cod','id','name','sex','age','hobby','birthdate'];


    /**
     * localiza e retorna um usuario pelo campo passado em $params
     * @param array $params
     * @return Usuarios
     */
    static public function list($id=null,Array $params=[])
    {
        DB::enableQueryLog();
        $devs = DB::table('devs');
        $devs->select(
        'devs.id',
        'devs.name',
        'devs.sex',
        'devs.age',
        'devs.hobby',
        'devs.birthdate',
    );
        if($id){
            $devs->where('devs.id', $id);
        }
        if($params){
            foreach($params as $idx => $param){
                if($idx =='name' || $idx =='hobby'){
                    $devs->where($idx, 'like', "%{$param}%");
                } else {
                    $devs->where($idx, '=', $param);
                }
            }
        }
        $devs->where('deleted', '=', 'N');
        $devs->orderBy('name');

        $result = $devs->get();
        // var_dump(DB::getQueryLog());exit;
        return $result;

    }

    
}