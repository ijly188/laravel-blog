<?php

namespace App\Repositories\Api;

use App\Entities\MainMenu;
use App\Entities\SystemUser;

class SystemUserRepository
{
    public function getMenu()
    {
        return MainMenu::with('relatedSubManu')
                        ->where('is_active', true)
                        ->orderBy('sort', 'asc')
                        ->get();
    }

    public function deliveryManTags()
    {
        return SystemUser::where('group', '7teaStoreManager')
                            ->orWhere('group', '7teaStoreClerk')
                            ->get();
    }

    public function getStatusChangeNotifySystemUser()
    {
        return SystemUser::where('group', '7teaStoreManager')
                            ->orWhere('group', '7teaStoreClerk')
                            ->orWhere('group', 'Root')
                            ->get();
    }
}
