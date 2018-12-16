<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contact extends Model
{
    /**
     * Train for soft delete
     */
    use SoftDeletes;

    protected $fillable = ['client_id', 'address', 'postcode'];
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['created_at', 'updated_at', 'deleted_at'];


    /**
     * Define relationship with Client model
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * return all contacts from DB
     * @return mixed
     */
    public static function getAllContacts()
    {
        return static::select('id', 'client_id', 'address', 'postcode')->with('client:id,first_name,email')->get();
    }
}
