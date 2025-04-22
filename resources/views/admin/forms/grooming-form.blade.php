
@extends('layouts.admin')

@section('title', 'Grooming Service Record')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Grooming Record</h2>
    
    <form action="{{ isset($record) 
    ? route('admin.pet-records.update-grooming', ['appointment' => $appointment->id, 'grooming_record' => $record->id]) 
    : route('admin.pet-records.store-grooming', ['appointment' => $appointment->id, 'pet' => $pet->id]) }}" 
    method="POST"
    enctype="multipart/form-data">
        @csrf
        @isset($record) @method('PUT') @endisset
        <input type="hidden" name="pet_id" value="{{ $pet->id }}">

        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-6">
            <h4 class="text-xl font-semibold text-orange-600 mb-4">Grooming Details</h4>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">Pet Name</label>
                    <p class="text-gray-900 font-semibold">{{ $pet->name }}</p>
                </div>
                
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">Service Type</label>
                    <p class="text-gray-900 font-semibold">Grooming</p>
                </div>
            </div>

            <div class="mb-6">
                <label for="notes" class="block mb-2 text-gray-700 font-medium">Notes</label>
                <textarea id="notes" name="notes" rows="4" class="w-full border rounded px-4 py-2" required>{{ $record->notes ?? old('notes') }}</textarea>
            </div>

            <div class="mb-6">
                <label for="products_used" class="block mb-2 text-gray-700 font-medium">Products Used (comma separated)</label>
                <input type="text" id="products_used" name="products_used" value="{{ isset($record) ? implode(', ', json_decode($record->products_used)) : old('products_used') }}" class="w-full border rounded px-4 py-2">
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <!-- Before Photos -->
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">Before Photos (Max 3)</label>
                    <input type="file" name="before_photos[]" multiple accept="image/*" class="w-full file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                    
                    @if(isset($record) && $record->before_photo_path)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-2">Current Before Photos:</p>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach(json_decode($record->before_photo_path) as $photo)
                                    <div class="relative group">
                                        <img src="{{ Storage::url('grooming/before/'.$photo) }}" 
                                             class="h-24 w-full object-cover rounded border">
                                        <div class="absolute inset-0 flex items-center justify-center gap-1 opacity-0 group-hover:opacity-100 bg-black bg-opacity-50 transition-opacity">
                                            <a href="{{ Storage::url('grooming/before/'.$photo) }}" 
                                               target="_blank" 
                                               class="p-1 text-white hover:text-orange-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                    class="p-1 text-white hover:text-red-300 delete-photo" 
                                                    data-url="{{ $photo }}" 
                                                    data-type="before">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
                
                <!-- After Photos -->
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">After Photos (Max 3)</label>
                    <input type="file" name="after_photos[]" multiple accept="image/*" class="w-full file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-orange-50 file:text-orange-700 hover:file:bg-orange-100">
                    
                    @if(isset($record) && $record->after_photo_path)
                        <div class="mt-4">
                            <p class="text-sm text-gray-500 mb-2">Current After Photos:</p>
                            <div class="grid grid-cols-3 gap-2">
                                @foreach(json_decode($record->after_photo_path) as $photo)
                                    <div class="relative group">
                                        <img src="{{ Storage::url('grooming/after/'.$photo) }}" 
                                             class="h-24 w-full object-cover rounded border">
                                        <div class="absolute inset-0 flex items-center justify-center gap-1 opacity-0 group-hover:opacity-100 bg-black bg-opacity-50 transition-opacity">
                                            <a href="{{ Storage::url('grooming/after/'.$photo) }}" 
                                               target="_blank" 
                                               class="p-1 text-white hover:text-orange-300">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                                </svg>
                                            </a>
                                            <button type="button" 
                                                    class="p-1 text-white hover:text-red-300 delete-photo" 
                                                    data-url="{{ $photo }}" 
                                                    data-type="after">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="flex justify-end space-x-4">
            <a href="{{ route('admin.pet-records.show', $appointment->id) }}" class="bg-gray-500 text-white px-6 py-2 rounded hover:bg-gray-600">Cancel</a>
            <button type="submit" class="bg-orange-600 text-white px-6 py-2 rounded hover:bg-orange-700">
                {{ isset($record) ? 'Update' : 'Submit' }} Record
            </button>
        </div>
    </form>
</div>

@if(isset($record))
<script>
document.querySelectorAll('.delete-photo').forEach(button => {
    button.addEventListener('click', function(e) {
        e.preventDefault();
        if (confirm('Are you sure you want to delete this photo?')) {
            fetch('{{ route("admin.pet-records.delete-grooming-photo", $record->id) }}', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    photo_url: this.dataset.url,
                    photo_type: this.closest('div').parentElement.previousElementSibling.textContent.includes('Before') ? 'before' : 'after'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.closest('div').remove();
                }
            });
        }
    });
});
</script>
@endif
@endsection