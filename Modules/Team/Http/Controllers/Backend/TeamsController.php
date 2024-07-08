<?php

namespace Modules\Team\Http\Controllers\Backend;

use App\Authorizable;
use App\Http\Controllers\Backend\BackendBaseController;

class TeamsController extends BackendBaseController
{
    use Authorizable;

    public function __construct()
    {
        // Page Title
        $this->module_title = 'Teams';

        // module name
        $this->module_name = 'teams';

        // directory path of the module
        $this->module_path = 'team::backend';

        // module icon
        $this->module_icon = 'fa-regular fa-sun';

        // module model name, path
        $this->module_model = "Modules\Team\Models\Team";
    }

}
