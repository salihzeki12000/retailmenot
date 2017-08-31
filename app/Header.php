<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/20/2017
 * Time: 6:06 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Header extends Model
{
    protected $table = 'header';

    protected $fillable = ['coupon_id'];

}