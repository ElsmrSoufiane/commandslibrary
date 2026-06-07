<x-filament-widgets::widget>
    <x-filament::section>

        <div style="font-family: 'Syne', ui-sans-serif, system-ui, sans-serif;">

            {{-- Google Fonts --}}
            <style>
                @import url('https://fonts.googleapis.com/css2?family=DM+Mono:wght@400;500&family=Syne:wght@400;500;700&display=swap');

                .fw-card {
                    background: #ffffff;
                    border: 0.5px solid #e5e7eb;
                    border-radius: 12px;
                    overflow: hidden;
                }

                .dark .fw-card {
                    background: #1f2937;
                    border-color: #374151;
                }

                .fw-header {
                    display: grid;
                    grid-template-columns: 1fr auto;
                    align-items: start;
                    padding: 1.25rem 1.25rem 0;
                }

                .fw-label {
                    font-size: 11px;
                    letter-spacing: 0.08em;
                    text-transform: uppercase;
                    color: #9ca3af;
                    margin-bottom: 4px;
                    font-family: 'Syne', sans-serif;
                }

                .fw-title {
                    font-size: 17px;
                    font-weight: 700;
                    color: #111827;
                    font-family: 'Syne', sans-serif;
                }

                .dark .fw-title {
                    color: #f9fafb;
                }

                .fw-badge {
                    font-size: 11px;
                    font-weight: 500;
                    padding: 3px 10px;
                    border-radius: 20px;
                    background: #dcfce7;
                    color: #15803d;
                    letter-spacing: 0.04em;
                    font-family: 'Syne', sans-serif;
                }

                .dark .fw-badge {
                    background: #14532d;
                    color: #86efac;
                }

                .fw-badge-blue {
                    background: #dbeafe;
                    color: #1d4ed8;
                }

                .dark .fw-badge-blue {
                    background: #1e3a5f;
                    color: #93c5fd;
                }

                .fw-badge-purple {
                    background: #ede9fe;
                    color: #7c3aed;
                }

                .dark .fw-badge-purple {
                    background: #4c1d95;
                    color: #c4b5fd;
                }

                .fw-big {
                    display: flex;
                    align-items: baseline;
                    gap: 8px;
                    padding: 1rem 1.25rem 0.5rem;
                }

                .fw-num {
                    font-family: 'DM Mono', monospace;
                    font-size: 48px;
                    font-weight: 500;
                    color: #111827;
                    line-height: 1;
                }

                .dark .fw-num {
                    color: #f9fafb;
                }

                .fw-unit {
                    font-size: 13px;
                    color: #6b7280;
                    font-family: 'Syne', sans-serif;
                }

                .fw-track {
                    height: 3px;
                    background: #f3f4f6;
                    margin: 0 1.25rem 1.25rem;
                    border-radius: 2px;
                    overflow: hidden;
                }

                .dark .fw-track {
                    background: #374151;
                }

                .fw-fill {
                    height: 100%;
                    background: #111827;
                    border-radius: 2px;
                    transition: width 0.6s ease;
                }

                .dark .fw-fill {
                    background: #f9fafb;
                }

                .fw-fill-green {
                    background: #16a34a;
                }

                .dark .fw-fill-green {
                    background: #22c55e;
                }

                .fw-fill-blue {
                    background: #2563eb;
                }

                .dark .fw-fill-blue {
                    background: #3b82f6;
                }

                .fw-fill-purple {
                    background: #7c3aed;
                }

                .dark .fw-fill-purple {
                    background: #8b5cf6;
                }

                .fw-stats {
                    display: grid;
                    grid-template-columns: 1fr 1fr 1fr;
                    padding: 0 1.25rem;
                }

                .fw-stat {
                    padding: 0.75rem 0;
                    text-align: center;
                }

                .fw-stat:not(:last-child) {
                    border-right: 0.5px solid #e5e7eb;
                }

                .dark .fw-stat:not(:last-child) {
                    border-right-color: #374151;
                }

                .fw-stat-val {
                    font-family: 'DM Mono', monospace;
                    font-size: 18px;
                    font-weight: 500;
                    color: #111827;
                }

                .dark .fw-stat-val {
                    color: #f9fafb;
                }

                .fw-stat-lbl {
                    font-size: 10px;
                    color: #9ca3af;
                    margin-top: 2px;
                    letter-spacing: 0.05em;
                    text-transform: uppercase;
                    font-family: 'Syne', sans-serif;
                }

                .fw-divider {
                    height: 0.5px;
                    background: #e5e7eb;
                    margin: 0.75rem 0 0;
                }

                .dark .fw-divider {
                    background: #374151;
                }

                .fw-list-head {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 0.75rem 1.25rem 0.25rem;
                }

                .fw-list-title {
                    font-size: 11px;
                    letter-spacing: 0.07em;
                    text-transform: uppercase;
                    color: #9ca3af;
                    font-family: 'Syne', sans-serif;
                }

                .fw-item {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    padding: 0.6rem 1.25rem;
                    border-top: 0.5px solid #f3f4f6;
                }

                .dark .fw-item {
                    border-top-color: #1f2937;
                }

                .fw-item:hover {
                    background: #f9fafb;
                }

                .dark .fw-item:hover {
                    background: #111827;
                }

                .fw-item-left {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                }

                .fw-dot {
                    width: 6px;
                    height: 6px;
                    border-radius: 50%;
                    background: #111827;
                    flex-shrink: 0;
                }

                .dark .fw-dot {
                    background: #f9fafb;
                }

                .fw-dot-green {
                    background: #16a34a;
                }

                .dark .fw-dot-green {
                    background: #22c55e;
                }

                .fw-dot-blue {
                    background: #2563eb;
                }

                .dark .fw-dot-blue {
                    background: #3b82f6;
                }

                .fw-dot-purple {
                    background: #7c3aed;
                }

                .dark .fw-dot-purple {
                    background: #8b5cf6;
                }

                .fw-item-name {
                    font-size: 13px;
                    color: #111827;
                    font-weight: 500;
                    font-family: 'Syne', sans-serif;
                }

                .dark .fw-item-name {
                    color: #f9fafb;
                }

                .fw-item-time {
                    font-size: 11px;
                    color: #9ca3af;
                    font-family: 'DM Mono', monospace;
                }

                .fw-footer {
                    padding: 1rem 1.25rem;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    border-top: 0.5px solid #e5e7eb;
                    margin-top: 0.5rem;
                }

                .dark .fw-footer {
                    border-top-color: #374151;
                }

                .fw-footer-text {
                    font-size: 12px;
                    color: #9ca3af;
                    font-family: 'Syne', sans-serif;
                }

                .fw-footer-btn {
                    font-size: 13px;
                    font-weight: 500;
                    color: #111827;
                    background: none;
                    border: 0.5px solid #d1d5db;
                    border-radius: 8px;
                    padding: 6px 14px;
                    cursor: pointer;
                    font-family: 'Syne', sans-serif;
                    display: flex;
                    align-items: center;
                    gap: 6px;
                    text-decoration: none;
                    transition: background 0.15s ease, border-color 0.15s ease;
                }

                .fw-footer-btn:hover {
                    background: #f9fafb;
                    border-color: #9ca3af;
                }

                .dark .fw-footer-btn {
                    color: #f9fafb;
                    border-color: #4b5563;
                }

                .dark .fw-footer-btn:hover {
                    background: #374151;
                }

                .fw-arrow {
                    width: 14px;
                    height: 14px;
                    stroke: currentColor;
                    fill: none;
                    stroke-width: 2;
                    stroke-linecap: round;
                    stroke-linejoin: round;
                }

                .fw-grid {
                    display: grid;
                    grid-template-columns: repeat(3, 1fr);
                    gap: 1.25rem;
                }

                @media (max-width: 1024px) {
                    .fw-grid {
                        grid-template-columns: 1fr;
                    }
                }
            </style>

            <div class="fw-grid">

                {{-- TECHNOLOGIES CARD --}}
                <div class="fw-card">
                    <div class="fw-header">
                        <div>
                            <div class="fw-label">{{ __('My Account') }}</div>
                            <div class="fw-title">{{ __('Technologies') }}</div>
                        </div>
                        <span class="fw-badge">{{ __('Active') }}</span>
                    </div>

                    <div class="fw-big">
                        <span class="fw-num">{{ $this->getTechnologiesCount() }}</span>
                        <span class="fw-unit">{{ __('total technologies') }}</span>
                    </div>

                    <div class="fw-track">
                        <div class="fw-fill fw-fill-green" style="width: {{ min($this->getTechnologiesCount() * 2, 100) }}%;"></div>
                    </div>

                    <div class="fw-stats">
                        <div class="fw-stat">
                            <div class="fw-stat-val">{{ $this->getTechnologiesCount() }}</div>
                            <div class="fw-stat-lbl">{{ __('Total') }}</div>
                        </div>
                        <div class="fw-stat">
                            <div class="fw-stat-val">{{ $this->getTechnologiesPublishedCount() }}</div>
                            <div class="fw-stat-lbl">{{ __('Published') }}</div>
                        </div>
                        <div class="fw-stat">
                            <div class="fw-stat-val">{{ $this->getUserStacksCount() }}</div>
                            <div class="fw-stat-lbl">{{ __('Stacks') }}</div>
                        </div>
                    </div>

                    @if($this->getTechnologiesCount() > 0)
                        <div class="fw-divider"></div>
                        <div class="fw-list-head">
                            <span class="fw-list-title">{{ __('Recent') }}</span>
                        </div>
                        @foreach($this->getRecentTechnologies() as $tech)
                            <div class="fw-item">
                                <div class="fw-item-left">
                                    <div class="fw-dot fw-dot-green"></div>
                                    <span class="fw-item-name">{{ $tech->titre ?? __('Technology') }}</span>
                                </div>
                                <span class="fw-item-time">{{ $tech->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    @endif

                    <div class="fw-footer">
                        <span class="fw-footer-text">{{ __('Updated just now') }}</span>
                        <a href="{{ url('/user/technologies') }}" class="fw-footer-btn">
                            {{ __('View all') }}
                            <svg class="fw-arrow" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M5 12h14M13 6l6 6-6 6"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- COMMUNITIES CARD --}}
                <div class="fw-card">
                    <div class="fw-header">
                        <div>
                            <div class="fw-label">{{ __('My Account') }}</div>
                            <div class="fw-title">{{ __('Communities') }}</div>
                        </div>
                        <span class="fw-badge fw-badge-blue">{{ __('Admin') }}</span>
                    </div>

                    <div class="fw-big">
                        <span class="fw-num">{{ $this->getUserCommunitiesCount() }}</span>
                        <span class="fw-unit">{{ __('total communities') }}</span>
                    </div>

                    <div class="fw-track">
                        <div class="fw-fill fw-fill-blue" style="width: {{ min($this->getUserCommunitiesCount() * 3, 100) }}%;"></div>
                    </div>

                    <div class="fw-stats">
                        <div class="fw-stat">
                            <div class="fw-stat-val">{{ $this->getUserCommunitiesCount() }}</div>
                            <div class="fw-stat-lbl">{{ __('Total') }}</div>
                        </div>
                        <div class="fw-stat">
                            <div class="fw-stat-val">{{ $this->getCommunityQuestionsCount() }}</div>
                            <div class="fw-stat-lbl">{{ __('Questions') }}</div>
                        </div>
                        <div class="fw-stat">
                            <div class="fw-stat-val">{{ $this->getCommunityTagsCount() }}</div>
                            <div class="fw-stat-lbl">{{ __('Tags') }}</div>
                        </div>
                    </div>

                    @if($this->getUserCommunitiesCount() > 0)
                        <div class="fw-divider"></div>
                        <div class="fw-list-head">
                            <span class="fw-list-title">{{ __('Recent') }}</span>
                        </div>
                        @foreach($this->getRecentCommunities() as $community)
                            <div class="fw-item">
                                <div class="fw-item-left">
                                    <div class="fw-dot fw-dot-blue"></div>
                                    <span class="fw-item-name">{{ $community->title ?? __('Community') }}</span>
                                </div>
                                <span class="fw-item-time">{{ $community->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    @endif

                    <div class="fw-footer">
                        <span class="fw-footer-text">{{ __('Updated just now') }}</span>
                        <a href="{{ url('/user/communities') }}" class="fw-footer-btn">
                            {{ __('View all') }}
                            <svg class="fw-arrow" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M5 12h14M13 6l6 6-6 6"/>
                            </svg>
                        </a>
                    </div>
                </div>

                {{-- CHAT ROOMS CARD --}}
                <div class="fw-card">
                    <div class="fw-header">
                        <div>
                            <div class="fw-label">{{ __('My Account') }}</div>
                            <div class="fw-title">{{ __('Chat Rooms') }}</div>
                        </div>
                        <span class="fw-badge fw-badge-purple">{{ __('Active') }}</span>
                    </div>

                    <div class="fw-big">
                        <span class="fw-num">{{ $this->getUserChatRoomsCount() }}</span>
                        <span class="fw-unit">{{ __('total chat rooms') }}</span>
                    </div>

                    <div class="fw-track">
                        <div class="fw-fill fw-fill-purple" style="width: {{ min($this->getUserChatRoomsCount() * 3, 100) }}%;"></div>
                    </div>

                    <div class="fw-stats">
                        <div class="fw-stat">
                            <div class="fw-stat-val">{{ $this->getUserChatRoomsCount() }}</div>
                            <div class="fw-stat-lbl">{{ __('Total') }}</div>
                        </div>
                        <div class="fw-stat">
                            <div class="fw-stat-val">{{ $this->getChatRoomMembersCount() }}</div>
                            <div class="fw-stat-lbl">{{ __('Members') }}</div>
                        </div>
                        <div class="fw-stat">
                            <div class="fw-stat-val">{{ $this->getChatRoomMessagesCount() }}</div>
                            <div class="fw-stat-lbl">{{ __('Messages') }}</div>
                        </div>
                    </div>

                    @if($this->getUserChatRoomsCount() > 0)
                        <div class="fw-divider"></div>
                        <div class="fw-list-head">
                            <span class="fw-list-title">{{ __('Recent') }}</span>
                        </div>
                        @foreach($this->getRecentChatRooms() as $chatRoom)
                            <div class="fw-item">
                                <div class="fw-item-left">
                                    <div class="fw-dot fw-dot-purple"></div>
                                    <span class="fw-item-name">{{ $chatRoom->title ?? __('Chat Room') }}</span>
                                </div>
                                <span class="fw-item-time">{{ $chatRoom->created_at->diffForHumans() }}</span>
                            </div>
                        @endforeach
                    @endif

                    <div class="fw-footer">
                        <span class="fw-footer-text">{{ __('Updated just now') }}</span>
                        <a href="{{ url('/user/chat-rooms') }}" class="fw-footer-btn">
                            {{ __('View all') }}
                            <svg class="fw-arrow" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                                <path d="M5 12h14M13 6l6 6-6 6"/>
                            </svg>
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </x-filament::section>
</x-filament-widgets::widget>
