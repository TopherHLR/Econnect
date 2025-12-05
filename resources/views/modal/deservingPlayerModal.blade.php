<!-- Reward Modal -->
<div id="rewardModal" class="hidden fixed inset-0 z-3000 bg-black/50 flex items-center justify-center p-4">
    <div class="bg-white p-6 rounded-lg shadow-xl w-96">
        <h2 class="text-xl font-bold mb-4">Give Reward</h2>

        <form action="{{ route('admin.giveReward') }}" method="POST">
            @csrf

            <input type="hidden" name="user_id" value="{{ $mostDeserving->user->user_id }}">

            <label class="block font-semibold mb-1">Select Voucher</label>
            <select name="voucher_id" class="w-full p-2 border rounded mb-4" required>
                @foreach (\App\Models\Voucher::where('is_active', true)->get() as $voucher)
                    <option value="{{ $voucher->voucher_id }}">
                        {{ $voucher->title }} ({{ $voucher->discount_value }})
                    </option>
                @endforeach
            </select>
            <button type="button" onclick="openVoucherShortcut()"
                class="w-full mt-[-10px] mb-4 text-sm text-green-700 underline hover:text-green-900">
                + Add New Voucher
            </button>
            <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
                Confirm Reward
            </button>
        </form>

        <button onclick="document.getElementById('rewardModal').classList.add('hidden')"
            class="mt-3 w-full py-2 border rounded">
            Cancel
        </button>
    </div>
</div>
<script>
    const rewardModal = document.getElementById('rewardModal');

    // -------------------------------------------------------------------
    // Open Voucher Modal Shortcut From Reward Modal
    // -------------------------------------------------------------------
    function openVoucherShortcut() {

        openAddVoucherModal();
    }

    function openRewardModal() {
        rewardModal.classList.remove('hidden');
    }

    // -------------------------------------------------------------------
    // OPEN ADD VOUCHER MODAL
    // -------------------------------------------------------------------
    function openAddVoucherModal() {
        form.reset();

        modalTitle.innerHTML = `<i class="fa-solid fa-ticket mr-2"></i> Add New Voucher`;
        voucherSubmit.innerHTML = `<i class="fa-solid fa-plus"></i> Add Voucher`;

        form.action = "{{ route('vouchers.store') }}";
        methodField.value = "POST";

        // ⭐ raise z-index dynamically
        addVoucherModal.style.zIndex = "9999";
        rewardModal.style.zIndex = "5000"; // ensure below

        // show add voucher modal
        addVoucherModal.classList.remove('hidden');
    }
</script>
