<?php

namespace App\Services\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Repositories\Api\MemberRepository;
use App\Support\Collection;

class MemberService
{
    protected $memberRepository;

    public function __construct(MemberRepository $memberRepository)
    {
        $this->memberRepository = $memberRepository;
    }

    public function getMemberList($sortTag)
    {
        $memberData = $this->memberRepository->getMemberList();
        $finalData = [];

        foreach ($memberData as $key => $memberInfo) {
            $created_at = '';
            
            $getMemberData[] = [
                'id' => $memberInfo->id,
                'name' => $memberInfo->name,
                'username' => $memberInfo->username,
                'phone' => $memberInfo->phone,
                'member_level' => $memberInfo->member_level,
                'created_at' => date('Y-m-d', strtotime($created_at)),
            ];
        }
        //根據篩選器篩選資料
        $collectMemberData = $this->sortCollection($getMemberData, $sortTag);
        $pagination = [
            'current_page' => $collectMemberData->currentpage(),
            'total_page' => $collectMemberData->lastPage(),
            'has_pre' => $collectMemberData->currentPage() == 1 ? false : $collectMemberData->currentPage() - 1,
            'has_next' => $collectMemberData->currentPage() == $collectMemberData->lastPage() ? false : $collectMemberData->currentPage() + 1,
        ];
        if ($collectMemberData->currentpage() > $collectMemberData->lastPage()) {
            return '超出頁數';
        }
        // 取得經過分頁函數的data資訊
        $finalData = $collectMemberData->items();
        //除了第一頁的data有去除key值，其他頁都沒有，所以要再做以下處理
        if ($collectMemberData->currentpage() != 1) {
            // 利用values()去除排序完的key，不然吐出來的data會有key值
            $finalData = $collectMemberData->values();
        }
        $total = [
            'pagination' => $pagination,
            'member_order_list' => $finalData,
        ];
        return $total;
    }

    public function sortCollection($memberData, $sortTag)
    {
        switch ($sortTag) {
            // 依照會員編號(舊到新)
            case 'all':
                return (new Collection($memberData))->sortByDesc('id')->values()->paginate(15);
                break;
            // 依照會員編號(新到舊)
            case '1':
                return (new Collection($memberData))->sortBy('id')->values()->paginate(15);
                break;
            // 依照消費金額（高到低)
            case '2':
                return (new Collection($memberData))->sortByDesc('totalCost')->values()->paginate(15);
                break;
            // 依照累積訂單數（多到少)
            case '3':
                return (new Collection($memberData))->sortByDesc('total_order')->values()->paginate(15);
                break;
        }
    }

    public function getMemberDetail($id)
    {
        //傳入會員Id，顯示會員資訊
        $getMemberList = $this->memberRepository->getMemberById($id);

        if ($getMemberList == null) {
            return false;
        } else {
            return $showMemberList = [
                'id' => $getMemberList->id,
                'name' => $getMemberList->name,
                'username' => $getMemberList->username,
                'phone' => $getMemberList->phone,
                'member_level' => $getMemberList->member_level,
                'email' => $getMemberList->email,
            ];
        }
    }

    public function getSearchMember($data)
    {
        $memberInfo = $this->memberRepository->searchMemberData($data);
        if ($memberInfo == null) {
            return '查無資訊';
        } else {
            $created_at = '';
            
            return $getMemberData[] = [
                'id' => $memberInfo->id,
                'name' => $memberInfo->name,
                'username' => $memberInfo->username,
                'phone' => $memberInfo->phone,
                'member_level' => $memberInfo->member_level,
                'created_at' => date('Y-m-d', strtotime($created_at)),
            ];
        }
    }

    public function updateMemberName(Request $request, $userId)
    {
        $otherService = app()->make(\App\Services\Api\OtherService::class);
        $apiUrl = $otherService->getApiUrl($request->path());

        switch ($request->type) {
            case 'name':
                $validator = validator::make($request->all(), [
                    'data' => 'required|string|max:10',
                ]);
                break;
            case 'phone':
                $validator = validator::make($request->all(), [
                    'data' => 'required|string|unique:members,phone|regex:/^[09]{2}[0-9]{8}$/',
                ]);
                break;
            case 'email':
                $validator = validator::make($request->all(), [
                    'data' => 'required|string|unique:members,email|email',
                ]);
                break;
        }
        if ($validator->fails()) {
            return $validator->errors()->first();
        }
        $memberName = $this->memberRepository->updateName($request->memberId, $request->type, $request->data, $request->ip(), $userId, $apiUrl);
        return $memberName;
    }
}
