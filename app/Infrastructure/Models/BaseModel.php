<?php

namespace App\Infrastructure\Models;

use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    /**
     * Infrastructure katmanındaki tüm modeller için ortak özellikler
     */

    /**
     * Model'in hangi connection'ı kullanacağını belirt
     */
    protected $connection = 'mysql';

    /**
     * Timestamps kullanılıp kullanılmayacağını belirt
     */
    public $timestamps = true;

    /**
     * Date casting için kullanılacak format
     */
    protected $dateFormat = 'Y-m-d H:i:s';
}
