<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Api\SystemUserService;
use Illuminate\Http\Request;
use JWTAuth;

class SystemUserController extends Controller
{
    protected $systemUserService;

    public function __construct(SystemUserService $systemUserService)
    {
        $this->systemUserService = $systemUserService;
    }

    // 後台人員-登入
    public function postLogin(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (!$token = JWTAuth::attempt($credentials)) {
            return response()->json([
                'success' => false,
                'message' => '帳號或密碼錯誤',
                'data' => ''
            ], 401);
        }

        return response()->json([
            'success' => true,
            'message' => '登入成功',
            'data' => [
                'token' => $token
            ]
        ], 200);
    }

    public function postLogout()
    {
        JWTAuth::invalidate();

        return response()->json([
            'success' => true,
            'message' => '登出成功',
            'data' => ''
        ], 200);
    }

    public function getAsideMenu()
    {
        if (JWTAuth::user()->is_active) {
            $mainMenuId = JWTAuth::user()->main_menu_id;
            $subMenuId = JWTAuth::user()->sub_menu_id;
            $asideMenu = $this->systemUserService->getMenu(JWTAuth::user(), $mainMenuId, $subMenuId);

            return response()->json([
                'success' => true,
                'message' => '取得Menu',
                'data' => $asideMenu
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => '使用者未啟用',
                'data' => ''
            ], 200);
        }
    }

    public function deliveryManTag()
    {
        $deliveryManTag = $this->systemUserService->getDeliveryManTag();
        if ($deliveryManTag) {
            return response()->json([
                'success' => true,
                'message' => 'success',
                'data' => $deliveryManTag,
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => '查無資料',
                'data' => '',
            ], 200);
        }
    }
}
