<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'payment_methods';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'method',
        'key',
        'value',
    ];

    public function getAll()
    {
        $query = PaymentMethod::all();
        return $query;
    }

    public function resetPaymentMethod($paymentMethod = null)
    {
        $reset = PaymentMethod::where('method', $paymentMethod)->delete();
        return $reset;
    }

    public function saveMethodKeyValue($data = array())
    {
        $save = PaymentMethod::insert($data);
        return $save;
    }
}
