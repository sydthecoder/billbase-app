<x-layouts.app title="Products">

    <x-ui.breadcrumb :items="[
        ['label' => 'Products'],
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
                            <th class="border border-gray-300 px-4 py-2">Price</th>
                            <th class="border border-gray-300 px-4 py-2">Unit</th>
                            <th class="border border-gray-300 px-4 py-2">Taxable</th>
                            <th class="border border-gray-300 px-4 py-2">Status</th>
                            <th class="border border-gray-300 px-4 py-2">
                                <a href="{{ route('products.create') }}"
                                   class="justify-center transform motion-safe:hover:scale-90 text-white bg-[#5727e7] py-2 px-8 focus:outline-none hover:bg-orange-600 rounded-lg shadow-2xl text-lg">
                                    +
                                </a>
                            </th>
                        </tr>
                    </thead>

                    <tbody>
                        @forelse ($products as $product)
                            <tr>
                                <td class="border border-gray-300 px-4 py-2">
                                    <a href="{{ route('products.show', $product->id) }}" class="underline">
                                        {{ $product->name }}
                                    </a>
                                </td>
                                <td class="border border-gray-300 px-4 py-2">R {{ number_format($product->price, 2) }}</td>
                                <td class="border border-gray-300 px-4 py-2">{{ $product->unit ?? '—' }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    @if ($product->is_taxable)
                                        <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Yes</span>
                                    @else
                                        <span class="inline-block px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">No</span>
                                    @endif
                                </td>
                                <td class="border border-gray-300 px-4 py-2">{{ ucfirst($product->status) }}</td>
                                <td class="border border-gray-300 px-4 py-2">
                                    <div class="inline-flex gap-2 items-center rounded-md shadow-sm">
                                        <a href="{{ route('products.show', $product->id) }}"
                                           class="text-gray-800 text-xs bg-white hover:bg-gray-300 border border-gray-300 rounded-lg font-medium px-2 py-2 inline-flex space-x-2 items-center">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                </svg>
                                            </span>
                                            <span class="hidden md:inline-block">View</span>
                                        </a>

                                        <a href="{{ route('products.edit', $product->id) }}"
                                           class="text-gray-800 text-xs bg-white hover:bg-gray-300 border border-gray-300 rounded-lg font-medium px-2 py-2 inline-flex space-x-2 items-center">
                                            <span>
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                    stroke="currentColor" class="w-5 h-5">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                </svg>
                                            </span>
                                            <span class="hidden md:inline-block">Edit</span>
                                        </a>

                                        <form method="POST" action="{{ route('products.destroy', $product->id) }}"
                                              onsubmit="return confirm('Delete product {{ $product->name }}?')" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-gray-800 text-xs bg-white hover:bg-orange-300 border border-gray-300 rounded-lg font-medium px-2 py-2 inline-flex space-x-2 items-center">
                                                <span>
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" class="w-5 h-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                    </svg>
                                                </span>
                                                <span class="hidden md:inline-block">Delete</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="border border-gray-300 px-4 py-8 text-center text-gray-400">
                                    No products yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>

</x-layouts.app>