<?php

namespace App\Repositories\Api;

use App\Entities\Member;
use Illuminate\Http\Request;

class MemberRepository
{
    public function getMemberList()
    {
        return Member::orderBy('id')
                        ->get();
    }

    public function searchMemberData($data)
    {
        return Member::where('username', $data)
                        ->orWhere('name', $data)
                        ->orWhere('phone', $data)
                        ->first();
    }

    public function getMemberById($memberId)
    {
        return Member::where('id', $memberId)->first();
    }

    public function updateName($memberId, $type, $data, $ip, $userId, $apiUrl)
    {
        $member = $this->getMemberById($memberId);

        switch ($type) {
            case 'name':
                $updateName = Member::where('id', $memberId)
                        ->update([
                            'name' => $data,
                        ]);
                break;
            case 'phone':
                $updateName = Member::where('id', $memberId)
                        ->update([
                            'phone' => $data,
                        ]);
                break;
            case 'email':
                $updateName = Member::where('id', $memberId)
                        ->update([
                            'email' => $data,
                        ]);
                break;
        }

        $newMember = $this->getMemberById($memberId);

        return $updateName;
    }

    public function deleteMemberById($userId)
    {
        $member = $this->getMemberById($userId);
        
        return Member::where('id', $userId)
                        ->update([
                            'is_active' => '0'
                        ]);
    }
}
