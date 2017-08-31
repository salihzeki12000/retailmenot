<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/17/2017
 * Time: 6:19 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $table = 'coupon';

    protected $fillable = ['link','store_id', 'type', 'code', 'value', 'description', 'exp_date'];

}