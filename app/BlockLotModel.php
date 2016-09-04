<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlockLotModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'block_lot';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['block_lot',
    						'coordinates'];

    public function homeowner(){
        return $this->hasOne('App\HomeOwnerInformationModel','block_lot_id');
    }
}
