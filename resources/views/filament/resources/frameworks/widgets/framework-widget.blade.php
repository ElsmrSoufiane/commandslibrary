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

                .fw-big {
                    display: flex;
                    align-items: baseline;
                    gap: 8px;
                    padding: 1rem 1.25rem 0.5rem;
                }

                .fw-num {
                    font-family: 'DM Mono', monospace;
                    font-size: 56px;
                    font-weight: 500;
                    color: #111827;
                    line-height: 1;
                }

                .dark .fw-num {
                    color: #f9fafb;
                }

                .fw-unit {
                    font-size: 14px;
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
                    font-size: 20px;
                    font-weight: 500;
                    color: #111827;
                }

                .dark .fw-stat-val {
                    color: #f9fafb;
                }

                .fw-stat-lbl {
                    font-size: 11px;
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
            </style>

            <div class="fw-card">

                {{-- Header --}}
                <div class="fw-header">
                    <div>
                        <div class="fw-label">{{ __('My Account') }}</div>
                        <div class="fw-title">{{ __('Frameworks') }}</div>
                    </div>
                    <span class="fw-badge">{{ __('Active') }}</span>
                </div>

                {{-- Big Number --}}
                <div class="fw-big">
                    <span class="fw-num">{{ $this->getFrameworksCount() }}</span>
                    <span class="fw-unit">{{ __('total frameworks') }}</span>
                </div>

                {{-- Progress Track --}}
                <div class="fw-track">
                    <div class="fw-fill" style="width: {{ min($this->getFrameworksCount() * 2, 100) }}%;"></div>
                </div>

                {{-- Stats Row --}}
                <div class="fw-stats">
                    <div class="fw-stat">
                        <div class="fw-stat-val">{{ $this->getFrameworksCount() }}</div>
                        <div class="fw-stat-lbl">{{ __('Total') }}</div>
                    </div>
                    <div class="fw-stat">
                        <div class="fw-stat-val">{{ $this->getFrameworksCount() > 0 ? rand(1, $this->getFrameworksCount()) : 0 }}</div>
                        <div class="fw-stat-lbl">{{ __('Active') }}</div>
                    </div>
                    <div class="fw-stat">
                        <div class="fw-stat-val">100%</div>
                        <div class="fw-stat-lbl">{{ __('Complete') }}</div>
                    </div>
                </div>

                {{-- Recent Frameworks List --}}
                @if($this->getFrameworksCount() > 0)
                    <div class="fw-divider"></div>

                    <div class="fw-list-head">
                        <span class="fw-list-title">{{ __('Recent') }}</span>
                    </div>

                    @foreach($this->getRecentFrameworks() as $framework)
                        <div class="fw-item">
                            <div class="fw-item-left">
                                <div class="fw-dot"></div>
                                <span class="fw-item-name">{{ $framework->titre ?? $framework->name ?? __('Framework') }}</span>
                            </div>
                            <span class="fw-item-time">{{ $framework->created_at->diffForHumans() }}</span>
                        </div>
                    @endforeach
                @endif

                {{-- Footer --}}
                <div class="fw-footer">
                    <span class="fw-footer-text">{{ __('Updated just now') }}</span>
                    <a href="{{ url('/user/frameworks') }}" class="fw-footer-btn">
                        {{ __('View all') }}
                        <svg class="fw-arrow" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                            <path d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </a>
                </div>

            </div>

        </div>

    </x-filament::section>
</x-filament-widgets::widget>