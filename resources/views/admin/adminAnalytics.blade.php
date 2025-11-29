@extends('layouts.adminLayout')

@section('title', 'Admin Analytics')

@section('content')
<div class="space-y-6">
    <!-- 📊 Header with Stats -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div class="space-y-2">
            <h1 class="text-4xl font-serif font-bold text-[#4F6B3F]">Admin Analytics</h1>
            <p class="font-sans text-[#6A8A52]">Monitor overall platform activity and eco-performance insights.</p>
        </div>
        
        <!-- Quick Stats -->
        <div class="flex flex-wrap gap-3">
            <div class="bg-[#F0F7E6] rounded-xl px-4 py-3 border border-[#D8E2CA]">
                <div class="text-2xl font-bold text-[#4F6B3F]">1,284</div>
                <div class="text-sm text-[#6A8A52]">Active Users</div>
            </div>
            <div class="bg-[#F0F7E6] rounded-xl px-4 py-3 border border-[#D8E2CA]">
                <div class="text-2xl font-bold text-[#4F6B3F]">92%</div>
                <div class="text-sm text-[#6A8A52]">Completion Rate</div>
            </div>
            <div class="bg-[#F0F7E6] rounded-xl px-4 py-3 border border-[#D8E2CA]">
                <div class="text-2xl font-bold text-[#4F6B3F]">42K</div>
                <div class="text-sm text-[#6A8A52]">Points Earned</div>
            </div>
        </div>
    </div>

  <!-- 🔍 Control Bar -->
<div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
    <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
        <!-- Search + Filter Group -->
        <div class="flex flex-col sm:flex-row gap-4 items-start sm:items-center flex-1">
            <!-- Search -->
            <div class="relative flex-1 min-w-[250px]">
                <input 
                    type="text" 
                    placeholder="Search by user or activity..."
                    class="bg-[#E0E9D6] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full 
                           focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#3B3B3B] font-sans"
                >
                <i class="fa-solid fa-search absolute right-3 top-3 text-[#7A8C4F] text-sm"></i>
            </div>

            <!-- Filter -->
            <select 
                class="bg-[#E0E9D6] border border-[#7A8C4F] text-sm text-[#3B3B3B] rounded-full py-2.5 px-4 
                       focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] font-sans"
            >
                <option value="">All Categories</option>
                <option value="carbon">Carbon Reduction</option>
                <option value="recycling">Recycling</option>
                <option value="cleanups">Clean-ups</option>
            </select>
        </div>

        <!-- Export Button Group -->
        <div class="relative" x-data="{ open: false }">
            <button 
                @click="open = !open"
                class="btn-eco btn-sage flex items-center gap-2"
            >
                <i class="fa-solid fa-download"></i>
                <span>Export Report</span>
                <i class="fa-solid fa-chevron-down transition-transform" :class="{ 'rotate-180': open }"></i>
            </button>

            <!-- Dropdown Menu -->
            <div 
                x-show="open" 
                @click.away="open = false"
                class="absolute right-0 mt-2 w-64 bg-white rounded-xl shadow-lg border border-[#E6EAD7] z-10"
                x-transition:enter="transition ease-out duration-200"
                x-transition:enter-start="opacity-0 transform scale-95"
                x-transition:enter-end="opacity-100 transform scale-100"
                x-transition:leave="transition ease-in duration-150"
                x-transition:leave-start="opacity-100 transform scale-100"
                x-transition:leave-end="opacity-0 transform scale-95"
            >
                <div class="p-2 space-y-1">
                    <button onclick="generateUserActivityPDF()" class="w-full text-left px-4 py-3 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-lg transition flex items-center gap-3">
                        <i class="fa-solid fa-chart-line text-[#7A8C4F]"></i>
                        User Activity Report
                    </button>
                    <button onclick="generateImpactAnalysisPDF()" class="w-full text-left px-4 py-3 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-lg transition flex items-center gap-3">
                        <i class="fa-solid fa-leaf text-[#7A8C4F]"></i>
                        Impact Analysis Report
                    </button>
                    <button onclick="generateQuestPerformancePDF()" class="w-full text-left px-4 py-3 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-lg transition flex items-center gap-3">
                        <i class="fa-solid fa-bullseye text-[#7A8C4F]"></i>
                        Quest Performance Stats
                    </button>
                    <button onclick="generateEcoActionsPDF()" class="w-full text-left px-4 py-3 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-lg transition flex items-center gap-3">
                        <i class="fa-solid fa-chart-bar text-[#7A8C4F]"></i>
                        Eco-Actions Completion Data
                    </button>
                    <button onclick="generatePointEconomyPDF()" class="w-full text-left px-4 py-3 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-lg transition flex items-center gap-3">
                        <i class="fa-solid fa-coins text-[#7A8C4F]"></i>
                        Point Economy Analytics
                    </button>
                    <button onclick="generateComprehensivePDF()" class="w-full text-left px-4 py-3 text-sm text-[#4F6B3F] hover:bg-[#F7F9F2] rounded-lg transition flex items-center gap-3">
                        <i class="fa-solid fa-file-export text-[#7A8C4F]"></i>
                        Comprehensive Dashboard Export
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
    <!-- 📈 Analytics Dashboard -->
    <div class="bg-white rounded-2xl shadow p-6 border border-[#E6EAD7]">
        <!-- Section Header -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-chart-pie text-[#7F8A4F] text-xl"></i>
                <div>
                    <h2 class="text-xl font-semibold text-[#4F6B3F]">Key Metrics & Charts</h2>
                    <p class="text-sm text-[#6A8A52]">Interactive analytics dashboard</p>
                </div>
            </div>
            <div class="text-sm text-[#7A8C4F]">
                <i class="fa-solid fa-arrows-left-right mr-1"></i>
                Scroll to explore
            </div>
        </div>

        <!-- Horizontal Scroll Container -->
        <div class="overflow-x-auto pb-6">
            <div class="flex gap-6 min-w-max">
                
                <!-- Eco-Actions Completed Over Time -->
                <div class="w-[600px] bg-[#FCF9EF] rounded-2xl shadow p-6 border border-[#D8E2CA] flex-shrink-0">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-chart-line text-[#7F8A4F] text-lg"></i>
                        <h3 class="text-lg font-semibold text-[#4F6B3F]">Eco-Actions Completed Over Time</h3>
                    </div>
                    <div class="h-64 flex items-center justify-center text-[#7A8C4F] bg-white rounded-xl border border-[#E0E9D6]">
                        <div class="text-center">
                            <i class="fa-solid fa-chart-line text-4xl mb-2 opacity-50"></i>
                            <p class="text-sm">Line Chart: Eco-Actions Over Time</p>
                        </div>
                    </div>
                </div>

                <!-- Top 10 Eco Actions -->
                <div class="w-[600px] bg-[#FCF9EF] rounded-2xl shadow p-6 border border-[#D8E2CA] flex-shrink-0">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-trophy text-[#7F8A4F] text-lg"></i>
                        <h3 class="text-lg font-semibold text-[#4F6B3F]">Top 10 Eco Actions</h3>
                    </div>
                    <div class="h-64 overflow-y-auto">
                        <table class="w-full text-sm text-[#4F3B2C]">
                            <thead class="bg-[#E9ECDF] text-[#4F6B3F] sticky top-0">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold">Rank</th>
                                    <th class="px-4 py-3 text-left font-semibold">Action</th>
                                    <th class="px-4 py-3 text-left font-semibold">Users</th>
                                    <th class="px-4 py-3 text-left font-semibold">Rate</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-4 py-3 font-semibold">1</td>
                                    <td class="px-4 py-3">Plastic-Free Week</td>
                                    <td class="px-4 py-3">420</td>
                                    <td class="px-4 py-3 text-green-700 font-semibold">92%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-4 py-3 font-semibold">2</td>
                                    <td class="px-4 py-3">Community Clean-Up</td>
                                    <td class="px-4 py-3">370</td>
                                    <td class="px-4 py-3 text-green-700 font-semibold">88%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-4 py-3 font-semibold">3</td>
                                    <td class="px-4 py-3">Tree Planting Drive</td>
                                    <td class="px-4 py-3">310</td>
                                    <td class="px-4 py-3 text-green-700 font-semibold">85%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-4 py-3 font-semibold">4</td>
                                    <td class="px-4 py-3">Energy Saving Challenge</td>
                                    <td class="px-4 py-3">295</td>
                                    <td class="px-4 py-3 text-green-700 font-semibold">83%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-4 py-3 font-semibold">5</td>
                                    <td class="px-4 py-3">Water Conservation</td>
                                    <td class="px-4 py-3">280</td>
                                    <td class="px-4 py-3 text-green-700 font-semibold">81%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-4 py-3 font-semibold">6</td>
                                    <td class="px-4 py-3">Zero-Waste Lifestyle</td>
                                    <td class="px-4 py-3">265</td>
                                    <td class="px-4 py-3 text-green-700 font-semibold">79%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-4 py-3 font-semibold">7</td>
                                    <td class="px-4 py-3">Sustainable Commute</td>
                                    <td class="px-4 py-3">250</td>
                                    <td class="px-4 py-3 text-green-700 font-semibold">77%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-4 py-3 font-semibold">8</td>
                                    <td class="px-4 py-3">Eco-Friendly Shopping</td>
                                    <td class="px-4 py-3">235</td>
                                    <td class="px-4 py-3 text-green-700 font-semibold">75%</td>
                                </tr>
                                <tr class="border-b border-[#E6EAD7] hover:bg-[#F7F9F2] transition">
                                    <td class="px-4 py-3 font-semibold">9</td>
                                    <td class="px-4 py-3">Food Waste Reduction</td>
                                    <td class="px-4 py-3">220</td>
                                    <td class="px-4 py-3 text-green-700 font-semibold">73%</td>
                                </tr>
                                <tr class="hover:bg-[#F7F9F2] transition">
                                    <td class="px-4 py-3 font-semibold">10</td>
                                    <td class="px-4 py-3">Digital Carbon Footprint</td>
                                    <td class="px-4 py-3">205</td>
                                    <td class="px-4 py-3 text-green-700 font-semibold">70%</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Point Economy -->
                <div class="w-[600px] bg-[#FCF9EF] rounded-2xl shadow p-6 border border-[#D8E2CA] flex-shrink-0">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-coins text-[#7F8A4F] text-lg"></i>
                        <h3 class="text-lg font-semibold text-[#4F6B3F]">Point Economy</h3>
                    </div>
                    <p class="text-sm text-[#6A8A52] mb-3">Points Earned vs Redeemed (Weekly)</p>
                    <div class="h-64 flex items-center justify-center text-[#7A8C4F] bg-white rounded-xl border border-[#E0E9D6]">
                        <div class="text-center">
                            <i class="fa-solid fa-chart-line text-4xl mb-2 opacity-50"></i>
                            <p class="text-sm">Dual Line Graph: Points Earned vs Redeemed</p>
                        </div>
                    </div>
                </div>

                <!-- Distribution of Point Sources -->
                <div class="w-[600px] bg-[#FCF9EF] rounded-2xl shadow p-6 border border-[#D8E2CA] flex-shrink-0">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-chart-pie text-[#7F8A4F] text-lg"></i>
                        <h3 class="text-lg font-semibold text-[#4F6B3F]">Distribution of Point Sources</h3>
                    </div>
                    <div class="h-64 flex items-center justify-center text-[#7A8C4F] bg-white rounded-xl border border-[#E0E9D6]">
                        <div class="text-center">
                            <i class="fa-solid fa-chart-pie text-4xl mb-2 opacity-50"></i>
                            <p class="text-sm">Pie Chart: Point Sources Distribution</p>
                        </div>
                    </div>
                </div>

                <!-- Quest Performance -->
                <div class="w-[600px] bg-[#FCF9EF] rounded-2xl shadow p-6 border border-[#D8E2CA] flex-shrink-0">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-bullseye text-[#7F8A4F] text-lg"></i>
                        <h3 class="text-lg font-semibold text-[#4F6B3F]">Quest Performance</h3>
                    </div>
                    <p class="text-sm text-[#6A8A52] mb-3">Completion Rate per Quests</p>
                    <div class="h-56 flex items-center justify-center text-[#7A8C4F] bg-white rounded-xl border border-[#E0E9D6] mb-3">
                        <div class="text-center">
                            <i class="fa-solid fa-chart-bar text-4xl mb-2 opacity-50"></i>
                            <p class="text-sm">Bar Chart: Quest Completion Rates</p>
                        </div>
                    </div>
                    <p class="text-xs text-[#7A8C4F] text-center">% Zero-Waste Challenge · Tree-Planting</p>
                </div>

                <!-- Invalid Submission Reasons -->
                <div class="w-[600px] bg-[#FCF9EF] rounded-2xl shadow p-6 border border-[#D8E2CA] flex-shrink-0">
                    <div class="flex items-center gap-3 mb-4">
                        <i class="fa-solid fa-cloud text-[#7F8A4F] text-lg"></i>
                        <h3 class="text-lg font-semibold text-[#4F6B3F]">Invalid Submission Reasons</h3>
                    </div>
                    <div class="h-64 flex items-center justify-center text-[#7A8C4F] bg-white rounded-xl border border-[#E0E9D6]">
                        <div class="text-center">
                            <i class="fa-solid fa-cloud text-4xl mb-2 opacity-50"></i>
                            <p class="text-sm">Word Cloud: Invalid Reasons</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Navigation Controls -->
        <div class="flex justify-center gap-3 mt-6">
            <button onclick="scrollGraphs(-1)" class="btn-eco btn-sage compact">
                <i class="fa-solid fa-chevron-left"></i>
                <span>Previous</span>
            </button>
            <button onclick="scrollGraphs(1)" class="btn-eco btn-sage compact">
                <span>Next</span>
                <i class="fa-solid fa-chevron-right"></i>
            </button>
        </div>
    </div>
</div>

<style>
    /* Button Styles */
    .btn-eco {
        @apply px-4 py-2.5 rounded-xl font-medium text-sm transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2;
    }
    
    .btn-sage {
        @apply bg-[#7A8C4F] text-white hover:bg-[#6A7A45] focus:ring-[#7A8C4F];
    }
    
    .compact {
        @apply px-3 py-2;
    }

    /* Custom scrollbar styling */
    .overflow-x-auto::-webkit-scrollbar {
        height: 8px;
    }

    .overflow-x-auto::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb {
        background: #7A8C4F;
        border-radius: 10px;
    }

    .overflow-x-auto::-webkit-scrollbar-thumb:hover {
        background: #6B7B43;
    }

    /* Table scroll styling */
    .h-64::-webkit-scrollbar {
        width: 6px;
    }

    .h-64::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 3px;
    }

    .h-64::-webkit-scrollbar-thumb {
        background: #7A8C4F;
        border-radius: 3px;
    }
</style>
<!-- Add this to your layout file or before the closing </body> tag -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<script>
// Optional: Add smooth scrolling and navigation indicators
document.addEventListener('DOMContentLoaded', function() {
    const scrollContainer = document.querySelector('.overflow-x-auto');
    
    // Add navigation buttons (optional enhancement)
    const navButtons = `
        <div class="flex justify-center gap-2 mt-4">
            <button onclick="scrollGraphs(-1)" class="px-4 py-2 bg-[#7A8C4F] text-white rounded-full text-sm hover:bg-[#6B7B43] transition">Previous</button>
            <button onclick="scrollGraphs(1)" class="px-4 py-2 bg-[#7A8C4F] text-white rounded-full text-sm hover:bg-[#6B7B43] transition">Next</button>
        </div>
    `;
    
    // Uncomment below if you want navigation buttons
    // scrollContainer.parentNode.insertAdjacentHTML('afterend', navButtons);
});

function scrollGraphs(direction) {
    const container = document.querySelector('.overflow-x-auto');
    const scrollAmount = 650; // Adjust based on card width + gap
    container.scrollBy({
        left: direction * scrollAmount,
        behavior: 'smooth'
    });
}
</script>

<!-- Add this script section to your existing file -->
<script>
function generateUserActivityPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Eco-themed header
    doc.setFillColor(79, 107, 63);
    doc.rect(0, 0, 210, 40, 'F');
    doc.setTextColor(255, 255, 255);
    doc.setFontSize(20);
    doc.text('User Activity Report', 105, 20, { align: 'center' });
    
    // Subtitle
    doc.setFontSize(12);
    doc.text('EcoPlatform Analytics Dashboard', 105, 30, { align: 'center' });
    
    // Report period
    doc.setTextColor(106, 138, 82);
    doc.setFontSize(10);
    doc.text(`Report Period: ${new Date().toLocaleDateString()}`, 15, 50);
    
    // Key metrics section
    doc.setTextColor(79, 107, 63);
    doc.setFontSize(16);
    doc.text('Key User Metrics', 15, 70);
    
    // Metrics table
    const metrics = [
        ['Total Active Users', '1,284'],
        ['New Users This Month', '156'],
        ['Avg. Session Duration', '12.4 min'],
        ['User Retention Rate', '78%'],
        ['Mobile App Usage', '64%']
    ];
    
    let yPos = 85;
    metrics.forEach(([label, value]) => {
        doc.setFontSize(10);
        doc.setTextColor(100, 100, 100);
        doc.text(label, 20, yPos);
        doc.setTextColor(79, 107, 63);
        doc.text(value, 80, yPos);
        yPos += 8;
    });
    
    // User activity chart placeholder
    doc.setDrawColor(122, 140, 79);
    doc.setLineWidth(0.5);
    doc.rect(15, 130, 180, 60);
    doc.setTextColor(122, 140, 79);
    doc.setFontSize(8);
    doc.text('User Activity Trend Chart (Last 30 Days)', 105, 135, { align: 'center' });
    
    // Top active users
    yPos = 200;
    doc.setTextColor(79, 107, 63);
    doc.setFontSize(14);
    doc.text('Top Active Users', 15, yPos);
    yPos += 10;
    
    const topUsers = [
        ['Sarah Chen', '42 eco-actions', '3,850 pts'],
        ['Miguel Rodriguez', '38 eco-actions', '3,420 pts'],
        ['Emma Wilson', '35 eco-actions', '3,150 pts'],
        ['James Kumar', '33 eco-actions', '2,970 pts'],
        ['Lisa Thompson', '30 eco-actions', '2,700 pts']
    ];
    
    topUsers.forEach(([name, actions, points]) => {
        doc.setFontSize(9);
        doc.setTextColor(79, 107, 63);
        doc.text(name, 20, yPos);
        doc.setTextColor(100, 100, 100);
        doc.text(actions, 70, yPos);
        doc.text(points, 120, yPos);
        yPos += 6;
    });
    
    // Footer
    doc.setFontSize(8);
    doc.setTextColor(150, 150, 150);
    doc.text('Generated by EcoPlatform Analytics • ' + new Date().toLocaleString(), 105, 290, { align: 'center' });
    
    doc.save('user-activity-report.pdf');
}
</script>


<script>
function generateImpactAnalysisPDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Header
    doc.setFillColor(106, 138, 82);
    doc.rect(0, 0, 210, 40, 'F');
    doc.setTextColor(255, 255, 255);
    doc.setFontSize(20);
    doc.text('Environmental Impact Report', 105, 20, { align: 'center' });
    doc.setFontSize(12);
    doc.text('Quantifying Eco-Action Contributions', 105, 30, { align: 'center' });
    
    // Impact summary
    doc.setTextColor(79, 107, 63);
    doc.setFontSize(16);
    doc.text('Environmental Impact Summary', 15, 55);
    
    const impactData = [
        ['CO₂ Reduction', '24.8 tons', 'Equivalent to 52 trees planted'],
        ['Plastic Waste Saved', '1,240 kg', '12,400 plastic bottles'],
        ['Energy Conserved', '18,500 kWh', 'Power for 15 homes/month'],
        ['Water Saved', '84,000 liters', '168,000 bottles of water']
    ];
    
    let yPos = 70;
    impactData.forEach(([metric, value, equivalent]) => {
        doc.setFontSize(11);
        doc.setTextColor(79, 107, 63);
        doc.text(metric, 20, yPos);
        doc.setFontSize(10);
        doc.setTextColor(106, 138, 82);
        doc.text(value, 70, yPos);
        doc.setTextColor(100, 100, 100);
        doc.text(equivalent, 110, yPos);
        yPos += 15;
    });
    
    // Top impact categories
    yPos = 140;
    doc.setTextColor(79, 107, 63);
    doc.setFontSize(14);
    doc.text('Impact by Category', 15, yPos);
    
    const categories = [
        ['Waste Reduction', '38%', '4,720 kg'],
        ['Energy Conservation', '29%', '18.5 MWh'],
        ['Carbon Reduction', '22%', '24.8 tons'],
        ['Water Conservation', '11%', '84k liters']
    ];
    
    yPos += 10;
    categories.forEach(([category, percentage, total]) => {
        doc.setFontSize(9);
        doc.setTextColor(79, 107, 63);
        doc.text(category, 20, yPos);
        doc.setTextColor(106, 138, 82);
        doc.text(percentage, 80, yPos);
        doc.setTextColor(100, 100, 100);
        doc.text(total, 110, yPos);
        yPos += 7;
    });
    
    // Community impact
    yPos = 185;
    doc.setTextColor(79, 107, 63);
    doc.setFontSize(14);
    doc.text('Community Participation', 15, yPos);
    
    const communityStats = [
        ['Total Participants', '1,284 users'],
        ['Average Impact/User', '19.3 kg CO₂ reduction'],
        ['Most Active Region', 'Southeast District'],
        ['Group Challenges Completed', '47 events']
    ];
    
    yPos += 10;
    communityStats.forEach(([stat, value]) => {
        doc.setFontSize(9);
        doc.setTextColor(100, 100, 100);
        doc.text(stat, 20, yPos);
        doc.setTextColor(79, 107, 63);
        doc.text(value, 70, yPos);
        yPos += 7;
    });
    
    doc.save('impact-analysis-report.pdf');
}
</script>

<script>
function generateQuestPerformancePDF() {
    const { jsPDF } = window.jspdf;
    const doc = new jsPDF();
    
    // Header
    doc.setFillColor(122, 140, 79);
    doc.rect(0, 0, 210, 40, 'F');
    doc.setTextColor(255, 255, 255);
    doc.setFontSize(20);
    doc.text('Quest Performance Report', 105, 20, { align: 'center' });
    doc.setFontSize(12);
    doc.text('Completion Rates & User Engagement', 105, 30, { align: 'center' });
    
    // Performance overview
    doc.setTextColor(79, 107, 63);
    doc.setFontSize(16);
    doc.text('Quest Performance Overview', 15, 55);
    
    const overview = [
        ['Total Active Quests', '24'],
        ['Average Completion Rate', '76%'],
        ['Total Participants', '8,420'],
        ['Avg. Points per Quest', '245 pts']
    ];
    
    let yPos = 70;
    overview.forEach(([metric, value]) => {
        doc.setFontSize(10);
        doc.setTextColor(100, 100, 100);
        doc.text(metric, 20, yPos);
        doc.setTextColor(79, 107, 63);
        doc.text(value, 80, yPos);
        yPos += 8;
    });
    
    // Top performing quests
    yPos = 105;
    doc.setTextColor(79, 107, 63);
    doc.setFontSize(14);
    doc.text('Top Performing Quests', 15, yPos);
    
    const topQuests = [
        ['Plastic-Free Week', '92%', '420 users', '1,050 pts'],
        ['Community Clean-Up', '88%', '370 users', '880 pts'],
        ['Tree Planting Drive', '85%', '310 users', '775 pts'],
        ['Energy Saving Challenge', '83%', '295 users', '738 pts'],
        ['Water Conservation', '81%', '280 users', '700 pts']
    ];
    
    yPos += 10;
    doc.setFontSize(8);
    doc.setTextColor(100, 100, 100);
    doc.text('Quest Name', 20, yPos);
    doc.text('Completion', 80, yPos);
    doc.text('Participants', 110, yPos);
    doc.text('Avg. Points', 150, yPos);
    yPos += 5;
    
    topQuests.forEach(([name, completion, users, points]) => {
        doc.setTextColor(79, 107, 63);
        doc.text(name, 20, yPos);
        doc.setTextColor(106, 138, 82);
        doc.text(completion, 80, yPos);
        doc.setTextColor(100, 100, 100);
        doc.text(users, 110, yPos);
        doc.text(points, 150, yPos);
        yPos += 6;
    });
    
    // Quest categories performance
    yPos = 165;
    doc.setTextColor(79, 107, 63);
    doc.setFontSize(14);
    doc.text('Performance by Category', 15, yPos);
    
    const categories = [
        ['Waste Reduction', '84%', '6/7 quests'],
        ['Energy & Carbon', '79%', '5/8 quests'],
        ['Community Action', '76%', '4/5 quests'],
        ['Education & Awareness', '72%', '3/4 quests']
    ];
    
    yPos += 10;
    categories.forEach(([category, successRate, activeQuests]) => {
        doc.setFontSize(9);
        doc.setTextColor(79, 107, 63);
        doc.text(category, 20, yPos);
        doc.setTextColor(106, 138, 82);
        doc.text(successRate, 80, yPos);
        doc.setTextColor(100, 100, 100);
        doc.text(activeQuests, 110, yPos);
        yPos += 7;
    });
    
    doc.save('quest-performance-report.pdf');
}
</script>
@endsection