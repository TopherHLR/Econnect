                <div class="relative">
                    <!-- Notification Modal / Dropdown -->
                    <div id="notification-modal"
                        class="hidden absolute right-0 mt-2 w-80 bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden z-50">
                        <div class="p-4 border-b border-gray-100 font-semibold bg-[#f5f8ef]">
                            Notifications
                        </div>
                        <ul id="notification-list" class="max-h-64 overflow-y-auto">
                            <!-- Notification items will be injected here -->
                            @foreach (App\Models\Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get() as $notif)
                                @php
                                    // Determine redirect based on notification title
                                    $title = strtolower($notif->title);

                                    if (str_contains($title, 'lifestyle')) {
                                        $url = url('/lifestyle');
                                    } elseif (str_contains($title, 'voucher')) {
                                        $url = url('/rewards');
                                    } elseif (str_contains($title, 'reward')) {
                                        $url = url('/rewards'); // rewards go to voucher page
                                    } elseif (str_contains($title, 'quest')) {
                                        $url = url('/quests');
                                    } else {
                                        $url = '#'; // default fallback
                                    }
                                @endphp

                                <a href="{{ $url }}" class="block">
                                    <li data-id="{{ $notif->notification_id }}"
                                        class="px-4 py-2 border-b border-gray-100 hover:bg-gray-50 flex justify-between items-start cursor-pointer">
                                        <div>
                                            <p class="font-medium text-gray-800">{{ $notif->title }}</p>
                                            <p class="text-gray-500 text-sm">{{ $notif->message }}</p>
                                            <p class="text-gray-400 text-xs mt-1">
                                                {{ $notif->created_at->diffForHumans() }}</p>
                                        </div>

                                        @if (!$notif->read_at)
                                            <span class="w-2 h-2 bg-red-500 rounded-full mt-1"></span>
                                        @endif
                                    </li>
                                </a>
                            @endforeach


                        </ul>
                        <div class="p-2 text-center bg-gray-50">
                            <button id="mark-all-read" class="text-sm text-[#6A8A52] hover:text-[#4F6B3F]">
                                Mark all as read
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Tailwind + Alpine.js for interactivity -->
                <script src="//unpkg.com/alpinejs" defer></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const modal = document.getElementById('notification-modal');
                        const notificationList = document.getElementById('notification-list');
                        const markAllBtn = document.getElementById('mark-all-read');
                        const notificationBtn = document.getElementById('notification-btn');
                        const globalDot = document.getElementById('notification-dot');

                        // CSRF token
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                        // Toggle modal visibility
                        notificationBtn.addEventListener('click', () => {
                            modal.classList.toggle('hidden');
                        });

                        // Close modal if clicking outside
                        document.addEventListener('click', function(event) {
                            if (!notificationBtn.contains(event.target) && !modal.contains(event.target)) {
                                modal.classList.add('hidden');
                            }
                        });

                        // Mark individual notifications as read
                        notificationList.querySelectorAll('li[data-id]').forEach(li => {
                            li.addEventListener('click', async () => {
                                const id = li.dataset.id;

                                // Skip if already read
                                if (!li.querySelector('span')) return;

                                try {
                                    const res = await fetch(`/notifications/mark-read/${id}`, {
                                        method: 'POST',
                                        headers: {
                                            'X-CSRF-TOKEN': csrfToken,
                                            'Content-Type': 'application/json'
                                        }
                                    });

                                    if (res.ok) {
                                        li.querySelector('span')?.remove();

                                        // Hide global dot if no unread notifications left
                                        if (notificationList.querySelectorAll('li span').length === 0 &&
                                            globalDot) {
                                            globalDot.style.display = 'none';
                                        }
                                    } else {
                                        console.error('Failed to mark as read', res.status);
                                    }
                                } catch (err) {
                                    console.error('Error marking notification as read:', err);
                                }
                            });
                        });

                        // Mark all notifications as read
                        markAllBtn.addEventListener('click', async () => {
                            try {
                                const res = await fetch('/notifications/mark-all-read', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': csrfToken,
                                        'Content-Type': 'application/json'
                                    }
                                });

                                if (res.ok) {
                                    // Remove all red dots in list
                                    notificationList.querySelectorAll('li span').forEach(el => el.remove());

                                    // Hide global red dot
                                    if (globalDot) globalDot.style.display = 'none';
                                } else {
                                    console.error('Failed to mark all as read', res.status);
                                }
                            } catch (err) {
                                console.error('Error marking all notifications as read:', err);
                            }
                        });
                    });
                </script>
