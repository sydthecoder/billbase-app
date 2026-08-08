<x-layouts.app title="New Invoice">
    <div>
        <div class="max-w-6xl">

            <x-ui.breadcrumb :items="[
                ['label' => 'Invoices', 'url' => route('invoices.index')],
                ['label' => 'New Invoice'],
            ]" />

            <form
                method="POST"
                action="{{ route('invoices.store') }}"
                x-data="{ loading: false }"
                @submit="loading = true"
                class="flex flex-col gap-8 pb-24"
            >
                @csrf

                @include('invoices._form')

                <div class="fixed bottom-0 right-0 left-65 bg-white shadow-lg px-6 py-4 border border-[#e5e7eb]">
                    <div class="flex justify-end gap-3">
                        <a href="{{ route('invoices.index') }}" class="w-fit bg-white border border-[#d1d5db] text-[#030712] font-medium px-4 py-2.5 rounded-xl hover:bg-[#f9fafb] transition-colors">
                            Cancel
                        </a>
                        <button
                            class="w-fit bg-primary-500 text-white font-medium px-4 py-2.5 rounded-xl shadow-md hover:bg-primary-600 transition-colors"
                            type="submit"
                            :disabled="loading"
                        >
                            <x-ui.button-loader />
                            <span x-text="loading ? 'Saving' : 'Save invoice'"></span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>