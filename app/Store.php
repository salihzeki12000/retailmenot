<?php
/**
 * Created by PhpStorm.
 * User: vuquo
 * Date: 8/17/2017
 * Time: 6:18 PM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Store extends Model
{

    protected $table = 'store';

    protected $fillable = ['name', 'category_id', 'img' , 'user_id'];


}