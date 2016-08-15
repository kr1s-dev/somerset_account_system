<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class VendorModel extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'vendors';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['created_by',
                            'updated_by',
                            'vendor_name',
                            'vendor_description',
                            'vendor_mobile_no',
                            'vendor_telephone_no',
                            'vendor_email_address',
                            'vendor_contact_person',];
}
