<x-layouts.app title="Product Categories">

    <x-ui.breadcrumb :items="[
        ['label' => 'Products', 'url' => route('products.index')],
        ['label' => 'Categories'],
    ]" />

    @if (session('success'))
        <div class="mb-4 rounded-lg bg-green-50 border border-green-200 text-green-700 text-sm px-4 py-3">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
            <ul class="list-disc list-inside space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <section class="text-gray-700">
        <div>
            <div class="flex justify-center">
                <table id="example" class="table-auto table-style w-full mx-auto">
                    <thead>
                        <tr>
                            <th class="border border-gray-300 px-4 py-2">Name</th>
                            <th class="border border-gray-300 px-4 py-2">Description</th>
                            <th class="border border-gray-300 px-4 py-2">
                                <a href="{{ route('products.categories.create') }}"
                                   class="justify-center transform motion-safe:hover:scale-90 text-white bg-[#5727e7] py-2 px-8 focus:outline-none hover:bg-orange-600 rounded-lg shadow-2xl text-lg">
                                    +
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($categories as $category)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $category->name }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    {{ $category->description ?? '—' }}
                                </td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <div class="inline-flex gap-2 items-center rounded-md shadow-sm">
                                        <a href="{{ route('products.categories.edit', $category->id) }}"
                                           class="text-gray-800 text-xs bg-white hover:bg-gray-300 border border-gray-300 rounded-lg font-medium px-2 py-2 inline-flex space-x-2 items-center">
                                            <span>
                                                <x-lucide-pencil class="w-5 h-5" />
                                            </span>
                                            <span class="hidden md:inline-block">Edit</span>
                                        </a>

                                        <form method="POST" action="{{ route('products.categories.destroy', $category->id) }}"
                                              onsubmit="return confirm('Delete category {{ $category->name }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-gray-800 text-xs bg-white hover:bg-orange-300 border border-gray-300 rounded-lg font-medium px-2 py-2 inline-flex space-x-2 items-center">
                                                <span>
                                                    <x-lucide-trash-2 class="w-5 h-5" />
                                                </span>
                                                <span class="hidden md:inline-block">Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="border border-gray-300 px-4 py-8 text-center text-gray-400">
                                    No categories yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</x-layouts.app>