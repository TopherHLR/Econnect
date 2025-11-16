@extends('layouts.adminLayout')

@section('title', 'Quests')

@section('content')
<div class="space-y-8">
    <!-- Header -->
    <div>
        <h1 class="text-3xl font-semibold text-[#4E3A2E]">Quests</h1>
        <p class="text-[#7A8C4F] mt-1">Create, manage, and validate sustainability challenges.</p>
    </div>

    <div class="flex flex-col md:flex-row gap-8">
      <!-- Sidebar -->
      <aside class="w-full md:w-1/4 max-w-xs bg-[#FCF9EF] rounded-2xl p-6 shadow border border-[#C6D0B2]">
          <div class="flex justify-between items-center mb-4">
              <h2 class="text-xl font-semibold text-[#4E3A2E]">Active Quests</h2>
              <button onclick="openQuestModal()" class="btn-eco btn-sage">+ New</button>
          </div>

          <ul id="questList" class="space-y-2 mb-6">
              <!-- Active Quests -->
              @foreach($quests->where('status', '!=', 'archived') as $quest)
                  <li data-quest="{{ $quest->quest_id }}" class="tab-eco cursor-pointer">
                      {{ $quest->title }}
                  </li>
              @endforeach

              <hr class="border-[#C6D0B2] mb-4 mt-4">

              <!-- Quest Collection -->
              <li data-quest="collection" class="tab-eco cursor-pointer">Quest Collection</li>
          </ul>

          <!-- Archive Dropdown -->
          <div class="relative">
              <button id="archiveDropdownBtn" class="btn-eco w-full flex justify-center items-center relative">
                  <span>Archive</span>
                  <svg id="archiveArrow" class="w-4 h-4 ml-2 absolute right-4 top-1/2 -translate-y-1/2 transition-transform duration-200"
                      fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                  </svg>
              </button>

              <ul id="archiveDropdownMenu" class="absolute left-0 right-0 bg-[#FCF9EF] border border-[#C6D0B2] rounded-lg mt-2 shadow-lg hidden z-10">
                  <!-- Archived Quests -->
                  @foreach($quests->where('status', 'archived') as $quest)
                      <li class="flex justify-between items-center px-4 py-2 hover:bg-[#E9F0E1] text-[#4E3A2E]">
                          <span class="cursor-pointer" data-quest="questTable-{{ $quest->quest_id }}">
                              {{ $quest->title }}
                          </span>

                          <!-- Recover form -->
                          <form action="{{ route('quests.recover', $quest->quest_id) }}" method="POST" onsubmit="return confirm('Recover this quest?')">
                              @csrf
                              <button type="submit" class="text-green-600 hover:text-green-800 font-semibold text-sm">
                                  Recover
                              </button>
                          </form>
                      </li>
                  @endforeach
              </ul>

          </div>
      </aside>


      <!-- Main Content -->
      <main class="flex-1 space-y-6">
          <div class="max-w-8xl mx-auto space-y-6 mt-7 ml-5 mr-5">
              <!-- Search bars -->
              <div class="flex flex-wrap items-center justify-between gap-4">
                  <div id="searchSubmissions" class="relative w-80">
                      <input type="text" placeholder="Search submissions..."
                          class="bg-[#E9F0E1] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#4E3A2E]">
                  </div>
                  <div id="searchQuests" class="relative w-80 hidden">
                      <input type="text" placeholder="Search quests..."
                          class="bg-[#E9F0E1] w-full pl-4 pr-10 py-2.5 border border-[#7A8C4F] rounded-full focus:outline-none focus:ring-2 focus:ring-[#7A8C4F] text-sm text-[#4E3A2E]">
                  </div>
              </div>

              <!-- Quest Tables -->
              <div id="questTables" class="space-y-8">
                  @foreach($quests as $quest)
                      <div id="questTable-{{ $quest->quest_id }}" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] {{ $loop->first ? '' : 'hidden' }}">
                          <h2 class="text-lg font-semibold text-[#4E3A2E] mb-4">{{ $quest->title }} Participants</h2>
                          
                          <table class="min-w-full text-sm text-[#4E3A2E] text-left border-collapse">
                              <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                                  <tr>
                                      <th class="px-4 py-2 w-16">#</th>
                                      <th class="px-4 py-2">Participant</th>
                                      <th class="px-4 py-2 w-32">Status</th>
                                  </tr>
                              </thead>
                              <tbody>
                                  @foreach($quest->submissions as $index => $submission)
                                      <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
                                          <td class="px-4 py-2">{{ $index + 1 }}</td>
                                          <td class="px-4 py-2 text-[#7A8C4F] cursor-pointer hover:underline"
                                              data-name="{{ $submission->user->first_name }} {{ $submission->user->last_name }}"
                                              data-status="{{ $submission->status }}"
                                              data-proof="{{ $submission->proof_link }}"
                                              data-submitted="{{ $submission->date_submitted }}"
                                              data-completed="{{ $submission->date_completed }}">
                                              {{ $submission->user->first_name }} {{ $submission->user->last_name }}
                                          </td>
                                          <td class="px-4 py-2 text-[#6A8A52]">{{ ucfirst($submission->status) }}</td>
                                      </tr>
                                  @endforeach
                              </tbody>
                          </table>

                          <!-- Submissions Table -->
                          <h3 class="text-md font-semibold text-[#4E3A2E] mt-6 mb-2">Submissions</h3>
                          <ul class="list-disc pl-6 text-[#7A8C4F]">
                              @foreach($quest->submissions as $submission)
                                  <li>
                                      {{ $submission->user->first_name }} {{ $submission->user->last_name }} -
                                      Status: {{ $submission->status }} -
                                      Submitted: {{ $submission->date_submitted }}
                                  </li>
                              @endforeach
                          </ul>
                      </div>
                  @endforeach

                  <!-- Quest Collection Table -->
                  <div id="collectionTable" class="bg-white rounded-lg shadow p-6 border border-[#E6EAD7] hidden">
                      <h2 class="text-lg font-semibold text-[#4E3A2E] mb-4">Quest Collection</h2>
                      <table class="min-w-full text-sm text-[#4E3A2E] text-left border-collapse">
                          <thead class="bg-[#E9ECDF] text-[#4F6B3F]">
                              <tr>
                                  <th class="px-4 py-2 w-16">#</th>
                                  <th class="px-4 py-2">Quest Title</th>
                                  <th class="px-4 py-2 w-64">Description</th>
                                  <th class="px-4 py-2 w-48">Category</th>
                                  <th class="px-4 py-2 w-32">Points</th>
                                  <th class="px-4 py-2 w-32">Start Date</th>
                                  <th class="px-4 py-2 w-32">End Date</th>
                                  <th class="px-4 py-2 w-32">Status</th>
                                  <th class="px-4 py-2 w-32">Actions</th>
                              </tr>
                          </thead>
                          <tbody>
                              @foreach($quests->where('status', '!=', 'archived') as $index => $quest)
                                  <tr class="border-b border-[#E6EAD7] hover:bg-[#FAFBF8]">
                                      <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                      <td class="px-4 py-2 text-[#4E3A2E]">{{ $quest->title }}</td>
                                      <td class="px-4 py-2">{{ $quest->description }}</td>
                                      <td class="px-4 py-2">{{ $quest->category }}</td>
                                      <td class="px-4 py-2">{{ $quest->points_reward }}</td>
                                      <td class="px-4 py-2">{{ $quest->start_date }}</td>
                                      <td class="px-4 py-2">{{ $quest->end_date }}</td>
                                      <!-- Status Dropdown -->
                                      <td class="px-4 py-2">
                                          <select name="status" class="border border-[#7A8C4F] rounded px-2 py-1 text-sm text-[#4E3A2E] status-dropdown" data-quest-id="{{ $quest->quest_id }}">
                                              <option value="active" {{ $quest->status === 'active' ? 'selected' : '' }}>Active</option>
                                              <option value="ending_soon" {{ $quest->status === 'ending_soon' ? 'selected' : '' }}>Ending Soon</option>
                                              <option value="closed" {{ $quest->status === 'closed' ? 'selected' : '' }}>Closed</option>
                                          </select>
                                      </td>

                                      <td class="px-4 py-2">
                                          <div class="flex gap-1.5">
                                              <button class="btn-action btn-edit" title="Edit Quest">
                                                  <i class="fas fa-edit"></i>
                                              </button>

                                              <!-- Archive Button via AJAX -->
                                              <button 
                                                  class="btn-action btn-archive" 
                                                  data-quest-id="{{ $quest->quest_id }}" 
                                                  title="Archive Quest">
                                                  <i class="fas fa-archive"></i>
                                              </button>
                                          </div>
                                      </td>

                                  </tr>
                              @endforeach

                          </tbody>
                      </table>
                  </div>

              </div>
          </div>
      </main>

    </div>
</div>
<!-- JS for dynamic quest table switching -->
<script>
document.addEventListener('DOMContentLoaded', () => {
    const questListItems = document.querySelectorAll('#questList li');
    const questTables = document.querySelectorAll('[id^="questTable-"]');
    const collectionTable = document.getElementById('collectionTable');

    questListItems.forEach(item => {
        item.addEventListener('click', () => {
            const selectedId = item.dataset.quest;

            // Hide all quest tables
            questTables.forEach(table => table.classList.add('hidden'));
            collectionTable.classList.add('hidden');

            if (selectedId === 'collection') {
                collectionTable.classList.remove('hidden');
            } else {
                // Show selected quest table
                const selectedTable = document.getElementById('questTable-' + selectedId);
                if (selectedTable) {
                    selectedTable.classList.remove('hidden');
                }
            }

            // Highlight active tab
            questListItems.forEach(li => li.classList.remove('bg-[#E9F0E1]', 'font-semibold'));
            item.classList.add('bg-[#E9F0E1]', 'font-semibold');
        });
    });
});

document.addEventListener('DOMContentLoaded', () => {
    const archiveBtn = document.getElementById('archiveDropdownBtn');
    const archiveMenu = document.getElementById('archiveDropdownMenu');
    const archiveArrow = document.getElementById('archiveArrow');

    archiveBtn.addEventListener('click', () => {
        archiveMenu.classList.toggle('hidden'); // show/hide menu
        archiveArrow.classList.toggle('rotate-180'); // rotate arrow
    });

    // Optional: close the dropdown if user clicks outside
    document.addEventListener('click', (e) => {
        if (!archiveBtn.contains(e.target) && !archiveMenu.contains(e.target)) {
            archiveMenu.classList.add('hidden');
            archiveArrow.classList.remove('rotate-180');
        }
    });
});

document.addEventListener('DOMContentLoaded', () => {

    // Status update via AJAX
    document.querySelectorAll('.status-dropdown').forEach(dropdown => {
        dropdown.addEventListener('change', (e) => {
            const questId = e.target.dataset.questId;
            const status = e.target.value;

            fetch(`/quests/${questId}/status`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ status })
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    alert(data.success); // optional feedback
                }
            })
            .catch(err => console.error(err));
        });
    });

});

document.addEventListener('DOMContentLoaded', () => {
    const archiveMenu = document.getElementById('archiveDropdownMenu');

    document.querySelectorAll('.btn-archive').forEach(button => {
        button.addEventListener('click', (e) => {
            e.preventDefault();
            const questId = button.dataset.questId;
            const questTitle = button.closest('tr').querySelector('td:nth-child(2)').innerText;

            if(!confirm('Are you sure you want to archive this quest?')) return;

            fetch(`/quests/${questId}/archive`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            })
            .then(res => res.json())
            .then(data => {
                if(data.success){
                    // Remove the row from the table
                    const row = button.closest('tr');
                    if(row) row.remove();

                    // Add the quest to the archive dropdown
                    const li = document.createElement('li');
                    li.className = "flex justify-between items-center px-4 py-2 hover:bg-[#E9F0E1] text-[#4E3A2E]";

                    li.innerHTML = `
                        <span class="cursor-pointer" data-quest="questTable-${questId}">${questTitle}</span>
                        <form onsubmit="return confirm('Recover this quest?')" class="ml-2" data-quest-id="${questId}">
                            <button type="button" class="text-green-600 hover:text-green-800 font-semibold text-sm btn-recover">Recover</button>
                        </form>
                    `;
                    archiveMenu.appendChild(li);

                    // Add recover button functionality
                    li.querySelector('.btn-recover').addEventListener('click', () => recoverQuest(questId, li));
                }
            })
            .catch(err => console.error(err));
        });
    });
        // Recover function
    function recoverQuest(questId, liElement){
        if(!confirm('Recover this quest?')) return;

        fetch(`/quests/${questId}/recover2`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(res => res.json())
        .then(data => {
            if(data.success){
                liElement.remove(); // Remove from archive dropdown

                // Optional: refresh table or re-add to active quests table
                location.reload(); // Or implement JS to add it back dynamically
            }
        });
    }
});
</script>
@include('modal.createQuestModal')
@include('modal.verifyUserModal')
@endsection
