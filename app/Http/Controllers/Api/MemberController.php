<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Api\MemberService;
use JWTAuth;

class MemberController extends Controller
{
    protected $memberService;

    public function __construct(MemberService $memberService)
    {
        $this->memberService = $memberService;
    }

    public function getAllMemberList($sortTag = 'all')
    {
        if ($sortTag != 'all' && $sortTag != '1' && $sortTag != '2' && $sortTag != '3') {
            return response()->json([
                'success' => false,
                'message' => '格式錯誤',
                'data' => '',
            ], 422);
        }
        $showMemberList = $this->memberService->getMemberList($sortTag);
        if (gettype($showMemberList) == 'string') {
            return response()->json([
                'success' => true,
                'message' => $showMemberList,
                'data' => '',
            ], 200);
        }
        return response()->json([
            'success' => true,
            'message' => '成功顯示會員列表',
            'data' => $showMemberList,
        ], 200);
    }

    public function getMemberDetail($id = null)
    {
        if (!is_numeric($id)) {
            return response()->json([
                'success' => false,
                'message' => '格式錯誤',
                'data' => '',
            ], 422);
        }

        $showMemberDetail = $this->memberService->getMemberDetail($id);

        if ($showMemberDetail) {
            return response()->json([
                'success' => true,
                'message' => '成功顯示會員詳細資訊',
                'data' => $showMemberDetail,
            ], 200);
        } else {
            return response()->json([
                'success' => true,
                'message' => '查無此會員',
                'data' => '',
            ], 200);
        }
    }

    public function searchMember($data = '')
    {
        if ($data == '') {
            return response()->json([
                'success' => false,
                'message' => '請輸入搜尋條件',
                'data' => '',
            ], 422);
        } else {
            $data = $this->memberService->getSearchMember($data);
            if (gettype($data) == 'string') {
                return response()->json([
                    'success' => true,
                    'message' => $data,
                    'data' => '',
                ], 200);
            }
            return response()->json([
                'success' => true,
                'message' => '成功顯示會員資訊',
                'data' => $data,
            ], 200);
        }
    }

    public function updateMemberDetail(Request $request)
    {
        $memberData = $this->memberService->updateMemberName($request, JWTAuth::user()->id);
        if (gettype($memberData) == 'string') {
            return response()->json([
                'success' => false,
                'message' => $memberData,
                'data' => '',
            ], 422);
        }
        if ($memberData) {
            return response()->json([
                'success' => true,
                'message' => '成功更新會員資料',
                'data' => '',
            ], 200);
        }
        return response()->json([
            'success' => true,
            'message' => '更新會員資料失敗',
            'data' => '',
        ], 200);
    }
}
