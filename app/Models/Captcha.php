<?php

namespace App\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
class Captcha extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'captchas';
    protected $fillable = [
        // Other fillable attributes...
        'captcha_toggle',
    ];

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    /*protected static function newFactory()
    {
        return \Modules\Captcha\database\factories\CaptchaFactory::new();
    }*/
}
