<?php

namespace App\Services\Api;

use App\Repositories\Api\SystemUserRepository;

class SystemUserService
{
    protected $systemUserRepository;

    public function __construct(SystemUserRepository $systemUserRepository)
    {
        $this->systemUserRepository = $systemUserRepository;
    }

    public function getMenu($user, $userMainMenuId, $userSubMenuId)
    {
        $allMainMenu = $this->systemUserRepository->getMenu();
        $mainMenuIds = json_decode($userMainMenuId);
        $subMenuIds = json_decode($userSubMenuId);

        foreach ($allMainMenu as $singleMainMenu) {
            $subMenu = [];
            $relatedSubMenuRule = $singleMainMenu
                                    ->relatedSubManu
                                    ->where('is_active', true)
                                    ->sortBy('sort');
            //篩選有存在於system_user裡的main_menu_id
            if (in_array($singleMainMenu['id'], $mainMenuIds)) {
                //有的話再進一步做關聯篩選
                foreach ($relatedSubMenuRule as $singleSubMenu) {
                    //篩選有存在於system_user裡的sub_menu_id
                    if (in_array($singleSubMenu['id'], $subMenuIds)) {
                        $subMenu[] = [
                            'name' => $singleSubMenu['name'],
                            'route' => $singleSubMenu['route']
                        ];
                    }
                }
                $mainMenu[] = [
                    'name' => $singleMainMenu['name'],
                    'icon' => $singleMainMenu['icon'],
                    'route' => $singleMainMenu['route'],
                    'children' => $subMenu
                ];
            }
        }
        $data = [
            'user' => $user->username,
            'main_menu' => $mainMenu
        ];

        return $data;
    }

    public function getDeliveryManTag()
    {
        $deliveryManTags = $this->systemUserRepository->deliveryManTags();
        foreach ($deliveryManTags as $deliveryManTag) {
            $data[] = [
                'id' => $deliveryManTag->id,
                'name' => $deliveryManTag->username,
            ];
        }

        return $data;
    }
}
