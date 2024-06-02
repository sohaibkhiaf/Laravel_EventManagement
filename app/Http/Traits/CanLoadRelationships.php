<?php

namespace App\Http\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

trait CanLoadRelationships
{

    public function loadRelations( Model|Builder|HasMany $for , array $relations) : Model|Builder|HasMany
    {

        foreach($relations as $key => $relation) 
        {

            if( filter_var( request()->query($key), FILTER_VALIDATE_BOOLEAN) === true){

                if($for instanceof Model){
                    $for->load($relation);
                }else{
                    $for->with($relation);
                }
                
            }
        }

        return $for;

    }
}
