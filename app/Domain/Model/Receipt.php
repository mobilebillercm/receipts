<?php
/**
 * Created by PhpStorm.
 * User: el
 * Date: 9/21/18
 * Time: 2:36 PM
 */

namespace App\Domain\Model;


use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{

    protected $table = 'receipts';

    protected $fillable = ['receiptid', 'userid', 'tenantid', 'transactionid', 'amount', 'address', 'date', 'body', 'date_sent',
        'current_balance', 'available_balance','beneficiary','type','verification_code', 'duplicata', 'made_by', 'currency'];


    public function __construct($receiptid = null, $userid = null, $tenantid = null, $transactionid = null, $amount = null, $address = null,
                                $date = null, $body = null, $date_sent = null, $current_balance = null,  $available_balance = null, $beneficiary = null,
                                $type = null, $verification_code = null, $duplicata = null, $made_by = null,  $currency = null, $attributes = array())
    {
        parent::__construct($attributes);
        $this->receiptid = $receiptid;
        $this->userid = $userid;
        $this->tenantid = $tenantid;
        $this->transactionid = $transactionid;
        $this->amount = $amount;
        $this->address = $address;
        $this->date = $date;
        $this->body = $body;
        $this->date_sent = $date_sent;
        $this->current_balance = $current_balance;
        $this->available_balance = $available_balance;
        $this->beneficiary = $beneficiary;
        $this->type = $type;
        $this->verification_code = $verification_code;
        $this->duplicata = $duplicata;
        $this->made_by = $made_by;
        $this->currency = $currency;
    }
}