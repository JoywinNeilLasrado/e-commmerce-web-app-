@extends('layouts.admin')

@section('title', 'Edit Brand - Admin Dashboard')

@section('content')
<div class="bg-gray-50 min-h-screen py-8">
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-8 flex items-center justify-between">
            <div>
                <h1 class="text-2xl font-black text-gray-900 tracking-tight">Edit Brand</h1>
                <p class="text-sm text-gray-500 mt-1 font-medium">Update manufacturer details and logo.</p>
            </div>
            <a href="{{ route('admin.brands.index') }}" class="text-sm font-bold text-gray-400 hover:text-gray-900 transition-colors flex items-center gap-1.5 group">
                <svg class="w-4 h-4 group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Back to List
            </a>
        </div>

        <form action="{{ route('admin.brands.update', $brand) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="space-y-6">
                <!-- Basic Info -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-8">
                    <div class="space-y-6">
                        <!-- Logo Upload -->
                        <div class="flex flex-col items-center gap-4 py-4">
                            <div class="relative group">
                                <div class="w-24 h-24 bg-gray-50 rounded-2xl border-2 border-gray-200 flex items-center justify-center overflow-hidden group-hover:border-blue-400 transition-colors p-2" id="logo-preview-container">
                                    <img src="{{ $brand->logo_url }}" alt="{{ $brand->name }}" class="max-w-full max-h-full object-contain">
                                </div>
                                <label class="absolute -bottom-2 -right-2 bg-white rounded-xl shadow-lg border border-gray-100 p-2 cursor-pointer hover:bg-gray-50 transition-all active:scale-90 group-hover:border-blue-200">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15.232 5.232l3.536 3.536M9 13l6.586-6.586a2 2 0 112.828 2.828L11.828 15.828a4 4 0 01-2.828 1.172H7v-2a4 4 0 011.172-2.828z"/></svg>
                                    <input type="file" name="logo" class="hidden" accept="image/*" onchange="previewLogo(this)">
                                </label>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-bold text-gray-900">Brand Logo</p>
                                <p class="text-[10px] text-gray-400 font-medium mt-0.5">Click the pencil icon to change logo</p>
                            </div>
                        </div>

                        <div class="grid grid-cols-1 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Brand Name</label>
                                <input type="text" name="name" value="{{ old('name', $brand->name) }}" required 
                                       placeholder="e.g. Apple, Samsung"
                                       class="block w-full rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 py-3 px-4 shadow-sm placeholder:text-gray-300">
                                @error('name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-400 uppercase tracking-wider mb-2">Description</label>
                                <textarea name="description" rows="3" 
                                          placeholder="A brief history or about the brand..."
                                          class="block w-full rounded-xl border-gray-200 text-sm focus:ring-blue-500 focus:border-blue-500 py-3 px-4 shadow-sm placeholder:text-gray-300 resize-none">{{ old('description', $brand->description) }}</textarea>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-8 pt-2">
                                <label class="flex flex-col gap-1 cursor-pointer group">
                                    <div class="flex items-center gap-3">
                                        <div class="relative inline-flex items-center">
                                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', $brand->is_active) ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-emerald-500"></div>
                                        </div>
                                        <span class="text-sm font-bold text-gray-700 group-hover:text-gray-900 transition-colors">Active Brand</span>
                                    </div>
                                    <span class="text-[10px] text-gray-400 leading-none pl-14">Visible on the store and search</span>
                                </label>

                                <label class="flex flex-col gap-1 cursor-pointer group">
                                    <div class="flex items-center gap-3">
                                        <div class="relative inline-flex items-center">
                                            <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $brand->is_featured) ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                                        </div>
                                        <span class="text-sm font-bold text-gray-700 group-hover:text-gray-900 transition-colors">Top Selling</span>
                                    </div>
                                    <span class="text-[10px] text-gray-400 leading-none pl-14">Show in the homepage carousel</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-end gap-3">
                    <a href="{{ route('admin.brands.index') }}" 
                       class="px-6 py-2.5 rounded-xl text-sm font-bold text-gray-500 hover:text-gray-900 hover:bg-gray-100 transition-all active:scale-95">
                        Cancel
                    </a>
                    <button type="submit" 
                            class="px-8 py-2.5 rounded-xl bg-gray-900 lg:bg-blue-600 text-white text-sm font-bold hover:bg-blue-700 transition-all shadow-lg shadow-blue-600/20 active:scale-95">
                        Update Brand
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function previewLogo(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const container = document.getElementById('logo-preview-container');
            container.innerHTML = `<img src="${e.target.result}" class="max-w-full max-h-full object-contain">`;
            container.classList.remove('border-dashed');
            container.classList.add('border-solid', 'p-2');
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
