<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnouncementModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'announcements';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['created_by',
    						'updated_by',
    						'headline',
    						'message'];
}
