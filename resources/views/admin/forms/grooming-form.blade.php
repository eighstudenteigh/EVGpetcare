{{-- resources/views/admin/forms/grooming-form.blade.php --}}
@extends('layouts.admin')

@section('title', 'Grooming Service Record')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h2 class="text-3xl font-bold text-gray-800 mb-6">Grooming Record</h2>
    
    <form action="{{ isset($record) ? route('admin.pet-records.update-grooming', ['appointment' => $appointment->id, 'grooming_record' => $record->id]) : route('admin.pet-records.store-grooming', ['appointment' => $appointment->id, 'pet' => $pet->id]) }}" method="POST" enctype="multipart/form-data">
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
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">Before Photos (Max 3)</label>
                    <input type="file" name="before_photos[]" multiple accept="image/*" class="w-full">
                    @if(isset($record) && $record->before_photo_path)
                        <div class="mt-4 grid grid-cols-3 gap-2">
                            @foreach(json_decode($record->before_photo_path) as $photo)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $photo) }}" class="h-24 w-full object-cover rounded">
                                    <a href="#" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 text-xs delete-photo" data-url="{{ $photo }}">×</a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
                
                <div>
                    <label class="block mb-2 text-gray-700 font-medium">After Photos (Max 3)</label>
                    <input type="file" name="after_photos[]" multiple accept="image/*" class="w-full">
                    @if(isset($record) && $record->after_photo_path)
                        <div class="mt-4 grid grid-cols-3 gap-2">
                            @foreach(json_decode($record->after_photo_path) as $photo)
                                <div class="relative">
                                    <img src="{{ asset('storage/' . $photo) }}" class="h-24 w-full object-cover rounded">
                                    <a href="#" class="absolute top-0 right-0 bg-red-500 text-white rounded-full p-1 text-xs delete-photo" data-url="{{ $photo }}">×</a>
                                </div>
                            @endforeach
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