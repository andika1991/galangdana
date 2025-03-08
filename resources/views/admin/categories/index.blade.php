<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="text-xl font-semibold text-gray-800">{{ __('Manage Categories') }}</h2>
            <a href="{{ route('admin.categories.create') }}" 
               class="px-4 py-2 bg-indigo-600 text-black rounded-lg shadow hover:bg-indigo-700 transition">
                + Add New
            </a>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-6xl mx-auto px-6">
            <div class="bg-white shadow-md rounded-lg p-6">
                @if ($categories->isEmpty())
                    <p class="text-center text-gray-500">Belum ada kategori. Tambahkan sekarang!</p>
                @else
                    <div class="grid sm:grid-cols-2 md:grid-cols-3 gap-6">
                        @foreach ($categories as $item)
                            <div class="bg-gray-50 p-4 rounded-lg shadow-sm hover:shadow-md transition">
                                <div class="flex items-center gap-3">
                                    <img src="{{ Storage::url($item->icon) }}" 
                                         alt="Category Image" 
                                         class="rounded-lg w-20 h-16 object-cover">
                                    <div>
                                        <h3 class="text-lg font-semibold text-gray-800">{{ $item->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $item->created_at->format('d M Y') }}</p>
                                    </div>
                                </div>
                                <div class="flex justify-end gap-2 mt-4">
                                    <a href="{{ route('admin.categories.edit', $item) }}" 
                                       class="px-3 py-2 bg-blue-500 text-white rounded-lg text-sm hover:bg-blue-600 transition">
                                        ✏ Edit
                                    </a>
                                    <form action="{{ route('admin.categories.destroy', $item) }}" method="POST"
                                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                      @csrf
                                      @method('DELETE')
                                      <button type="submit" 
                                              class="px-3 py-2 bg-red-500 text-white rounded-lg text-sm hover:bg-red-600 transition">
                                          🗑 Delete
                                      </button>
                                  </form>
                                  
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
