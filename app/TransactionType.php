<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TransactionType extends Model
{
    //
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'debit',
        'details',
        'prime',
        'for_all_services',
        'for_activities',
        'creator_id',
    ];

    public function services(){
      return $this->belongsToMany('App\Service','service_transaction_type');
    }

    public function transactionTypes(){
          $categories = [
                  [ 'name' => 'sale' ,         'debit' => true  , 'prime' => true ,  'for_all_services' => false, 'for_activities' => true,  'for_payroll' => false,  'details' => 'involves sale of service', 'services' => ['rooms','foods','drinks']],
                  [ 'name' => 'purchase' ,     'debit' => false , 'prime' => true ,  'for_all_services' => false, 'for_activities' => false, 'for_payroll' => false, 'details' => 'involves buying of stock or items directly essential for the asset', 'services' => ['rooms','foods','drinks']],
                  [ 'name' => 'discount' ,     'debit' => false , 'prime' => false , 'for_all_services' => true,  'for_activities' => false, 'for_payroll' => false, 'details' => 'involves any amount deducted from the actuall price of a the asset'],
                  [ 'name' => 'booking' ,      'debit' => true  , 'prime' => true ,  'for_all_services' => false, 'for_activities' => false, 'for_payroll' => false, 'details' => 'involves reservation of room or venue for a specified customer', 'services' => ['rooms','venues']],
                  [ 'name' => 'loss' ,         'debit' => false , 'prime' => true ,  'for_all_services' => false, 'for_activities' => false, 'for_payroll' => false, 'details' => 'involves damaged drink or food', 'services' => ['foods','drinks']],
                  [ 'name' => 'loan' ,         'debit' => false , 'prime' => false , 'for_all_services' => false, 'for_activities' => true,  'for_payroll' => false, 'details' => 'involves money loaned from a department or a loaned service value', 'services' => ['foods','drinks','rooms']],
                  [ 'name' => 'loan payment' , 'debit' => true  , 'prime' => false , 'for_all_services' => false, 'for_activities' => true,  'for_payroll' => true, 'details' => 'involves money that is paid back from a previous loan of service or money','services' => ['foods','drinks','rooms']],
                  [ 'name' => 'salary' ,       'debit' => false , 'prime' => false , 'for_all_services' => true,  'for_activities' => false, 'for_payroll' => true, 'details' => 'involves salary which is paid monthly' ],
                  [ 'name' => 'incetive' ,     'debit' => false , 'prime' => false , 'for_all_services' => true,  'for_activities' => false, 'for_payroll' => true,  'details' => 'involves money or service value offered to a member'],
                  [ 'name' => 'payee' ,        'debit' => false , 'prime' => false , 'for_all_services' => false,  'for_activities' => false, 'for_payroll' => true,  'details' => 'involves money for tax associated with the members paid salary','services' =>[]],
                  [ 'name' => 'tax' ,          'debit' => false , 'prime' => false , 'for_all_services' => false,  'for_activities' => false, 'for_payroll' => true, 'details' => 'involves direclty payable tax','services' =>[]],
                  [ 'name' => 'expenditure' ,  'debit' => false , 'prime' => true ,  'for_all_services' => true,  'for_activities' => false, 'for_payroll' => false, 'details' => 'involves expenses that are coincidential, do not occur on a daily basis'],
                  [ 'name' => 'pettycash' ,    'debit' => false , 'prime' => true ,  'for_all_services' => false,  'for_activities' => false, 'for_payroll' => false, 'details' => 'involves expenses that occur on a daily basis and usaully controlled in small amounts', 'services' => ['rooms','foods','drinks']],
                  [ 'name' => 'handover' ,     'debit' => false , 'prime' => true ,  'for_all_services' => true,   'for_activities' => true,  'for_payroll' => true, 'details' => 'involves movement of the balances in terms of cash between memmbers'],
          ];

          return $categories;
      }
}
