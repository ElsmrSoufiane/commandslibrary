<?php

namespace App\Filament\Widgets;

use App\Models\ChatRoom;
use App\Models\Community;
use App\Models\Technology;
use Filament\Widgets\Widget;

class UserDashboardWidget extends Widget
{
    protected int|string|array $columnSpan = 'full';

    protected string $view = 'filament.widgets.user-dashboard-widget';

    public function getTechnologiesCount(): int
    {
        return Technology::where('user_id', auth()->user()->id)->count();
    }

    public function getTechnologiesPublishedCount(): int
    {
        return Technology::where('user_id', auth()->user()->id)->where('published', true)->count();
    }

    public function getUserStacksCount(): int
    {
        return \App\Models\Stack::whereHas('technology', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->count();
    }

    public function getRecentTechnologies()
    {
        return Technology::where('user_id', auth()->user()->id)
            ->latest()
            ->take(3)
            ->get();
    }

    public function getUserCommunitiesCount(): int
    {
        return Community::whereHas('admins', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->count();
    }

    public function getCommunityQuestionsCount(): int
    {
        return \App\Models\Question::whereHas('community.admins', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->count();
    }

    public function getCommunityTagsCount(): int
    {
        $communityIds = Community::whereHas('admins', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->pluck('id');

        return \App\Models\Tags::whereHas('communities', function ($q) use ($communityIds) {
            $q->whereIn('community_id', $communityIds);
        })->count();
    }

    public function getRecentCommunities()
    {
        return Community::whereHas('admins', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })
            ->latest()
            ->take(3)
            ->get();
    }

    public function getUserChatRoomsCount(): int
    {
        return ChatRoom::where('user_id', auth()->user()->id)->count();
    }

    public function getChatRoomMembersCount(): int
    {
        $chatRoomIds = ChatRoom::where('user_id', auth()->user()->id)->pluck('id');

        return \App\Models\User::whereHas('chatRooms', function ($q) use ($chatRoomIds) {
            $q->whereIn('chat_room_id', $chatRoomIds);
        })->count();
    }

    public function getChatRoomMessagesCount(): int
    {
        return \App\Models\Message::whereHas('chatRoom', function ($q) {
            $q->where('user_id', auth()->user()->id);
        })->count();
    }

    public function getRecentChatRooms()
    {
        return ChatRoom::where('user_id', auth()->user()->id)
            ->latest()
            ->take(3)
            ->get();
    }
}
