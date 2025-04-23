{{-- resources/views/customer/appointments/partials/service-grooming.blade.php --}}
<div class="mt-4 pl-4 border-l-2 border-blue-200 bg-blue-50 rounded-lg p-4">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
            <p class="font-medium text-gray-700">Groomer Name:</p>
            <p class="text-gray-900">{{ $record->grooming->groomer_name ?? 'Not specified' }}</p>
        </div>
        
        <div>
            <p class="font-medium text-gray-700">Grooming Type:</p>
            <p class="text-gray-900">{{ $record->grooming->grooming_type ?? 'Not specified' }}</p>
        </div>
        
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Products Used:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->grooming->products_used ?? 'None listed' }}</p>
        </div>
        
        <div>
            <p class="font-medium text-gray-700">Coat Condition:</p>
            <p class="text-gray-900">{{ $record->grooming->coat_condition ?? 'Not specified' }}</p>
        </div>
        
        <div>
            <p class="font-medium text-gray-700">Skin Condition:</p>
            <p class="text-gray-900">{{ $record->grooming->skin_condition ?? 'Not specified' }}</p>
        </div>
        
        @if($record->grooming->behavior_notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Behavior Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->grooming->behavior_notes }}</p>
        </div>
        @endif
        
        @if($record->grooming->special_instructions)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Special Instructions:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->grooming->special_instructions }}</p>
        </div>
        @endif
        
        @if($record->notes)
        <div class="md:col-span-2">
            <p class="font-medium text-gray-700">Additional Notes:</p>
            <p class="text-gray-900 whitespace-pre-line">{{ $record->notes }}</p>
        </div>
        @endif
    </div>

    <!-- Photo Display Section -->
    @if($record->before_photo_path || $record->after_photo_path)
    <div class="mt-6 border-t pt-4">
        <h4 class="font-medium text-gray-700 mb-3">Grooming Photos</h4>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @if($record->before_photo_path)
            <div>
                <p class="font-medium text-sm text-gray-600 mb-1">Before</p>
                <div class="flex flex-wrap gap-2">
                    @foreach(json_decode($record->before_photo_path) as $photo)
                    <div class="relative group">
                        <img src="{{ Storage::url('grooming/before/'.$photo) }}" 
                             class="h-24 w-24 object-cover rounded border border-gray-200 cursor-pointer"
                             onclick="openModal('{{ Storage::url('grooming/before/'.$photo) }}')">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
            
            @if($record->after_photo_path)
            <div>
                <p class="font-medium text-sm text-gray-600 mb-1">After</p>
                <div class="flex flex-wrap gap-2">
                    @foreach(json_decode($record->after_photo_path) as $photo)
                    <div class="relative group">
                        <img src="{{ Storage::url('grooming/after/'.$photo) }}" 
                             class="h-24 w-24 object-cover rounded border border-gray-200 cursor-pointer"
                             onclick="openModal('{{ Storage::url('grooming/after/'.$photo) }}')">
                    </div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>

<!-- Image Modal (placed at the bottom of the page) -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4">
    <div class="max-w-4xl w-full">
        <div class="relative">
            <img id="modalImage" src="" class="max-h-screen mx-auto rounded-lg">
            <button onclick="closeModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function openModal(imageSrc) {
        document.getElementById('modalImage').src = imageSrc;
        document.getElementById('imageModal').classList.remove('hidden');
        document.body.classList.add('overflow-hidden');
    }

    function closeModal() {
        document.getElementById('imageModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }
</script>
@endpush