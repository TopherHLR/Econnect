<div id="ecoDetailModal"
     class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-center z-50">
  <div class="bg-white rounded-3xl shadow-lg border border-green-100 max-w-4xl w-full mx-4 p-8 relative animate-fadeIn">
    <!-- Close Button -->
    <button onclick="closeEcoModal()"
            class="absolute top-6 right-6 text-gray-400 hover:text-[#5C7919] transition cursor-pointer">
      ✕
    </button>

    <!-- Title -->
    <h1 id="ecoModalTitle"
        class="text-3xl font-serif font-semibold text-center text-[#5C7919] mb-6">
      <!-- Dynamic title -->
    </h1>

    <!-- Image -->
    <img id="ecoModalImage"
         src=""
         alt=""
         class="rounded-xl w-full max-h-[300px] object-cover mb-6">

    <!-- Content -->
    <div id="ecoModalContent"
         class="text-sm leading-relaxed text-gray-700 space-y-3">
      <!-- Filled dynamically -->
    </div>

    <!-- Action Button (for Eco Actions only) -->
    <div class="mt-8 text-center">
      <button id="ecoModalActionBtn"
              class="hidden bg-[#5C7919]/10 text-[#5C7919] text-sm px-4 py-2 rounded-full hover:bg-[#5C7919]/20 transition">
        Mark as Done
      </button>
    </div>
  </div>
</div>