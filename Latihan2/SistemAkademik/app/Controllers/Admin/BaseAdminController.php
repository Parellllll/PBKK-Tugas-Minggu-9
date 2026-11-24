<?php

namespace App\Controllers\Admin;

use App\Controllers\AbstractRoleController;

abstract class BaseAdminController extends AbstractRoleController
{
    protected function expectedRole(): string
    {
        return 'admin';
    }
}

