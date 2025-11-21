                <!-- Notification Modal / Dropdown -->
                <div id="notification-modal"
                    class="hidden absolute right-0 mt-2 w-80 bg-white shadow-lg border border-gray-200 rounded-xl overflow-hidden z-50">
                    <div class="p-4 border-b border-gray-100 font-semibold bg-[#f5f8ef]">
                        Notifications
                    </div>
                    <ul id="notification-list" class="max-h-64 overflow-y-auto">
                        <!-- Notification items will be injected here -->
                        @foreach (App\Models\Notification::where('user_id', Auth::id())->orderBy('created_at', 'desc')->get() as $notif)
                            <li
                                class="px-4 py-2 border-b border-gray-100 hover:bg-gray-50 flex justify-between items-start">
                                <div>
                                    <p class="font-medium text-gray-800">{{ $notif->title }}</p>
                                    <p class="text-gray-500 text-sm">{{ $notif->message }}</p>
                                    <p class="text-gray-400 text-xs mt-1">{{ $notif->created_at->diffForHumans() }}</p>
                                </div>
                                @if (!$notif->read_at)
                                    <span class="w-2 h-2 bg-red-500 rounded-full mt-1"></span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                    <div class="p-2 text-center bg-gray-50">
                        <button id="mark-all-read" class="text-sm text-[#6A8A52] hover:text-[#4F6B3F]">Mark all as
                            read</button>
                    </div>
                </div>
                <!-- Tailwind + Alpine.js for interactivity -->
                <script src="//unpkg.com/alpinejs" defer></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        const btn = document.getElementById('notification-btn');
                        const modal = document.getElementById('notification-modal');

                        btn.addEventListener('click', () => {
                            modal.classList.toggle('hidden');
                        });

                        // Optional: Close modal when clicking outside
                        document.addEventListener('click', function(event) {
                            if (!btn.contains(event.target) && !modal.contains(event.target)) {
                                modal.classList.add('hidden');
                            }
                        });

                        // Mark all notifications as read (AJAX example)
                        const markAllBtn = document.getElementById('mark-all-read');
                        markAllBtn.addEventListener('click', async () => {
                            try {
                                const response = await fetch('/notifications/mark-all-read', {
                                    method: 'POST',
                                    headers: {
                                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                        'Content-Type': 'application/json'
                                    }
                                });
                                if (response.ok) {
                                    modal.querySelectorAll('li span').forEach(el => el.remove());
                                    document.getElementById('notification-dot').style.display = 'none';
                                }
                            } catch (err) {
                                console.error(err);
                            }
                        });
                    });
                </script>
