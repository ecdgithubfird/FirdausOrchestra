<?php

namespace Modules\EventSetting\Models;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventSetting extends BaseModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'eventsettings';

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\EventSetting\database\factories\EventSettingFactory::new();
    }
}