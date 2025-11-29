@extends('layouts.adminLayout')

@section('title', 'System Settings')

@section('content')
<div class="space-y-6">
    <!-- ⚙️ Header -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div class="space-y-2">
            <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">System Settings</h1>
            <p class="font-sans text-[#6A8A52]">Configure platform preferences and admin controls.</p>
        </div>
        
        <!-- Quick Actions -->
        <div class="flex flex-wrap gap-2 justify-end">
            <button class="btn-eco btn-sage compact" onclick="saveAllSettings()">
                <i class="fa-solid fa-floppy-disk"></i>
                <span class="hidden lg:inline">Save All</span>
            </button>
            <button class="btn-eco btn-leaf compact" onclick="resetToDefaults()">
                <i class="fa-solid fa-rotate-left"></i>
                <span class="hidden lg:inline">Reset Defaults</span>
            </button>
        </div>
    </div>

    <!-- 🧩 Settings Sections -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">

        <!-- 🌿 Platform Rules -->
        <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
            <div class="flex items-center gap-3 mb-4">
                <i class="fa-solid fa-gear text-[#7F8A4F] text-lg"></i>
                <h2 class="text-xl font-semibold text-[#4F6B3F]">Platform Rules</h2>
            </div>

            <!-- Daily Action Limit -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-[#4F6B3F] mb-2">Daily Action Limit</label>
                <div class="relative">
                    <input 
                        type="number" 
                        value="100"
                        min="1"
                        max="500"
                        class="w-full bg-[#F4F6EB] border border-[#E0E9D6] rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-[#7A8C4F] focus:outline-none"
                    >
                    <div class="absolute right-3 top-1/2 transform -translate-y-1/2 text-[#7A8C4F] text-sm">
                        actions/day
                    </div>
                </div>
                <p class="text-xs text-[#6A8A52] mt-1">Maximum eco-actions users can complete daily</p>
            </div>

            <!-- Points System -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-[#4F6B3F] mb-2">Points per Action</label>
                <input 
                    type="number" 
                    value="10"
                    min="1"
                    max="100"
                    class="w-full bg-[#F4F6EB] border border-[#E0E9D6] rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-[#7A8C4F] focus:outline-none"
                >
                <p class="text-xs text-[#6A8A52] mt-1">Base points awarded for completed actions</p>
            </div>

            <!-- Streak Bonus -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-[#4F6B3F] mb-2">Streak Bonus Points</label>
                <input 
                    type="number" 
                    value="5"
                    min="0"
                    max="50"
                    class="w-full bg-[#F4F6EB] border border-[#E0E9D6] rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-[#7A8C4F] focus:outline-none"
                >
                <p class="text-xs text-[#6A8A52] mt-1">Extra points for consecutive daily participation</p>
            </div>

            <button class="btn-eco btn-leaf w-full">
                <i class="fa-solid fa-save"></i>
                Save Rules
            </button>
        </div>

        <!-- 🔔 Notifications -->
        <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
            <div class="flex items-center gap-3 mb-4">
                <i class="fa-solid fa-bell text-[#7F8A4F] text-lg"></i>
                <h2 class="text-xl font-semibold text-[#4F6B3F]">Notifications</h2>
            </div>

            <div class="space-y-4">
                <div class="flex items-center justify-between p-3 bg-[#F8F9F5] rounded-xl border border-[#E6EAD7]">
                    <div>
                        <div class="font-medium text-[#4F6B3F] text-sm">New Submissions</div>
                        <div class="text-xs text-[#6A8A52]">Email alerts for pending approvals</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-[#7A8C4F] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#7A8C4F]"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-3 bg-[#F8F9F5] rounded-xl border border-[#E6EAD7]">
                    <div>
                        <div class="font-medium text-[#4F6B3F] text-sm">System Alerts</div>
                        <div class="text-xs text-[#6A8A52]">Critical system notifications</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-[#7A8C4F] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#7A8C4F]"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-3 bg-[#F8F9F5] rounded-xl border border-[#E6EAD7]">
                    <div>
                        <div class="font-medium text-[#4F6B3F] text-sm">Weekly Reports</div>
                        <div class="text-xs text-[#6A8A52]">Platform performance summaries</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-[#7A8C4F] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#7A8C4F]"></div>
                    </label>
                </div>

                <div class="flex items-center justify-between p-3 bg-[#F8F9F5] rounded-xl border border-[#E6EAD7]">
                    <div>
                        <div class="font-medium text-[#4F6B3F] text-sm">Voucher Alerts</div>
                        <div class="text-xs text-[#6A8A52]">Low stock and expiry warnings</div>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" checked class="sr-only peer">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:ring-2 peer-focus:ring-[#7A8C4F] rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#7A8C4F]"></div>
                    </label>
                </div>
            </div>

            <button class="btn-eco btn-leaf w-full mt-4">
                <i class="fa-solid fa-bell"></i>
                Update Preferences
            </button>
        </div>

        <!-- 🔒 Security -->
        <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
            <div class="flex items-center gap-3 mb-4">
                <i class="fa-solid fa-shield-halved text-[#7F8A4F] text-lg"></i>
                <h2 class="text-xl font-semibold text-[#4F6B3F]">Security</h2>
            </div>

            <!-- Session Timeout -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-[#4F6B3F] mb-2">Session Timeout</label>
                <select class="w-full bg-[#F4F6EB] border border-[#E0E9D6] rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-[#7A8C4F] focus:outline-none">
                    <option value="30">30 minutes</option>
                    <option value="60" selected>1 hour</option>
                    <option value="120">2 hours</option>
                    <option value="240">4 hours</option>
                </select>
                <p class="text-xs text-[#6A8A52] mt-1">Auto-logout after inactivity</p>
            </div>

            <!-- Password Requirements -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-[#4F6B3F] mb-2">Password Policy</label>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center gap-2 text-[#6A8A52]">
                        <i class="fa-solid fa-check text-xs"></i>
                        Minimum 8 characters
                    </div>
                    <div class="flex items-center gap-2 text-[#6A8A52]">
                        <i class="fa-solid fa-check text-xs"></i>
                        Numbers and letters
                    </div>
                    <div class="flex items-center gap-2 text-[#6A8A52]">
                        <i class="fa-solid fa-check text-xs"></i>
                        Special characters
                    </div>
                </div>
            </div>

            <!-- Admin Verification -->
            <div class="border-t border-[#E6EAD7] pt-4">
                <div class="flex items-center gap-2 mb-3">
                    <i class="fa-solid fa-key text-[#7A8C4F]"></i>
                    <span class="font-medium text-[#4F6B3F] text-sm">Admin Verification</span>
                </div>
                <input 
                    type="password" 
                    placeholder="Current password for changes..."
                    class="w-full bg-[#F4F6EB] border border-[#E0E9D6] rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-[#7A8C4F] focus:outline-none mb-3"
                >
                <button class="btn-eco btn-sage w-full">
                    <i class="fa-solid fa-user-shield"></i>
                    Verify Identity
                </button>
            </div>
        </div>

        <!-- 📊 Data Management -->
        <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
            <div class="flex items-center gap-3 mb-4">
                <i class="fa-solid fa-database text-[#7F8A4F] text-lg"></i>
                <h2 class="text-xl font-semibold text-[#4F6B3F]">Data Management</h2>
            </div>

            <!-- Auto Cleanup -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-[#4F6B3F] mb-2">Auto-Cleanup Logs</label>
                <select class="w-full bg-[#F4F6EB] border border-[#E0E9D6] rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-[#7A8C4F] focus:outline-none">
                    <option value="30">30 days</option>
                    <option value="90" selected>90 days</option>
                    <option value="180">180 days</option>
                    <option value="365">1 year</option>
                    <option value="never">Never</option>
                </select>
                <p class="text-xs text-[#6A8A52] mt-1">Delete old system logs automatically</p>
            </div>

            <!-- Data Export -->
            <div class="space-y-3">
                <button class="btn-eco btn-view w-full text-left justify-start">
                    <i class="fa-solid fa-download"></i>
                    Export User Data
                </button>
                <button class="btn-eco btn-view w-full text-left justify-start">
                    <i class="fa-solid fa-chart-simple"></i>
                    Export Analytics Data
                </button>
                <button class="btn-eco btn-view w-full text-left justify-start">
                    <i class="fa-solid fa-file-export"></i>
                    Export System Logs
                </button>
            </div>

            <!-- Dangerous Actions -->
            <div class="border-t border-[#E6EAD7] pt-4 mt-4">
                <div class="text-sm font-medium text-[#4F6B3F] mb-3">⚠️ Dangerous Actions</div>
                <button 
                    onclick="confirmAction('clearLogs')"
                    class="btn-eco btn-archive w-full text-left justify-start mb-2"
                >
                    <i class="fa-solid fa-broom"></i>
                    Clear All Logs
                </button>
                <button 
                    onclick="confirmAction('resetPoints')"
                    class="btn-eco btn-archive w-full text-left justify-start"
                >
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset Point System
                </button>
            </div>
        </div>

        <!-- 🎨 Appearance -->
        <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
            <div class="flex items-center gap-3 mb-4">
                <i class="fa-solid fa-palette text-[#7F8A4F] text-lg"></i>
                <h2 class="text-xl font-semibold text-[#4F6B3F]">Appearance</h2>
            </div>

            <!-- Theme Selection -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-[#4F6B3F] mb-3">Theme</label>
                <div class="grid grid-cols-2 gap-3">
                    <div class="border-2 border-[#7A8C4F] rounded-xl p-3 text-center cursor-pointer bg-[#F0F7E6]">
                        <div class="w-6 h-6 rounded-full bg-[#4F6B3F] mx-auto mb-1"></div>
                        <div class="text-xs font-medium text-[#4F6B3F]">Eco Green</div>
                    </div>
                    <div class="border-2 border-gray-300 rounded-xl p-3 text-center cursor-pointer hover:border-[#7A8C4F]">
                        <div class="w-6 h-6 rounded-full bg-gray-600 mx-auto mb-1"></div>
                        <div class="text-xs font-medium text-gray-600">Dark Mode</div>
                    </div>
                </div>
            </div>

            <!-- Dashboard Density -->
            <div class="mb-5">
                <label class="block text-sm font-medium text-[#4F6B3F] mb-2">Dashboard Density</label>
                <select class="w-full bg-[#F4F6EB] border border-[#E0E9D6] rounded-xl py-3 px-4 text-sm focus:ring-2 focus:ring-[#7A8C4F] focus:outline-none">
                    <option value="comfortable">Comfortable</option>
                    <option value="compact" selected>Compact</option>
                    <option value="spacious">Spacious</option>
                </select>
            </div>

            <button class="btn-eco btn-leaf w-full">
                <i class="fa-solid fa-eye"></i>
                Apply Changes
            </button>
        </div>
    </div>
</div>

<style>
    .btn-eco {
        @apply px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 flex items-center gap-2;
    }
    
    .btn-leaf {
        @apply bg-[#6A8A52] text-white hover:bg-[#5C7919] focus:ring-[#6A8A52];
    }
    
    .btn-sage {
        @apply bg-[#7A8C4F] text-white hover:bg-[#6A7A45] focus:ring-[#7A8C4F];
    }
    
    .btn-view {
        @apply bg-[#F0F7E6] text-[#4F6B3F] hover:bg-[#E9F0E1] focus:ring-[#4F6B3F];
    }
    
    .btn-archive {
        @apply bg-[#FEF2F2] text-[#DC2626] hover:bg-[#FECACA] focus:ring-[#DC2626];
    }
    
    .compact {
        @apply px-3 py-2 text-xs;
    }
</style>

<script>
function saveAllSettings() {
    // Show saving indicator
    const button = event.target;
    const originalText = button.innerHTML;
    button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Saving...</span>';
    button.disabled = true;
    
    // Simulate API call
    setTimeout(() => {
        button.innerHTML = '<i class="fa-solid fa-check"></i><span>All Settings Saved!</span>';
        setTimeout(() => {
            button.innerHTML = originalText;
            button.disabled = false;
        }, 2000);
    }, 1000);
}

function resetToDefaults() {
    if (confirm('Reset all settings to default values? This cannot be undone.')) {
        // Show resetting indicator
        const button = event.target;
        const originalText = button.innerHTML;
        button.innerHTML = '<i class="fa-solid fa-spinner fa-spin"></i><span>Resetting...</span>';
        
        // Simulate reset
        setTimeout(() => {
            button.innerHTML = '<i class="fa-solid fa-check"></i><span>Defaults Restored!</span>';
            setTimeout(() => {
                button.innerHTML = originalText;
                // Reload or reset form fields here
                location.reload();
            }, 1500);
        }, 1000);
    }
}

function confirmAction(action) {
    const messages = {
        clearLogs: 'Clear all system logs? This will delete all audit history.',
        resetPoints: 'Reset the entire point economy? All user points will be set to zero.'
    };
    
    if (confirm(messages[action] + '\n\nThis action cannot be undone.')) {
        // Add password verification for dangerous actions
        const password = prompt('Enter admin password to continue:');
        if (password) {
            // Process the action
            alert(`${action.replace(/([A-Z])/g, ' $1').toUpperCase()} initiated...`);
        }
    }
}
</script>
@endsection