<!-- Brands Tab -->
<div id="merks-tab" class="tab-content hidden">
    <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl border border-white/20 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gradient-to-r from-purple-100 to-purple-200">
                    <tr>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Code</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Name</th>
                        <th class="px-6 py-4 text-left text-sm font-semibold text-slate-700">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-200">
                    @forelse($merks as $merk)
                        <tr class="hover:bg-purple-50/50 transition-colors duration-200">
                            <td class="px-6 py-4 text-sm font-mono text-slate-600">{{ $merk->code }}</td>
                            <td class="px-6 py-4 font-medium text-slate-900">{{ $merk->name }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <button onclick='showEditMerkForm(@json($merk))' class="p-2 text-purple-600 hover:bg-purple-50 rounded-lg transition-colors duration-200" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="{{ route('brand.destroy', $merk->code) }}" method="POST" onsubmit="return confirm('Delete this brand?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 hover:bg-red-50 rounded-lg transition-colors duration-200" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center justify-center text-slate-500">
                                    <i class="fas fa-crown text-4xl mb-4"></i>
                                    <p class="text-lg font-medium">No brands available</p>
                                    <p class="text-sm">Add your first brand to get started</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Add Brand Form -->
<div id="addMerkForm" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-start overflow-auto pt-10 z-50">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 my-8 shadow-2xl border border-white/20">
        <div class="p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-violet-600 bg-clip-text text-transparent">Add New Brand</h2>
                <button onclick="hideAddMerkForm()" class="p-2 hover:bg-slate-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times text-slate-400"></i>
                </button>
            </div>
            <form method="POST" action="{{ route('brand.store') }}" class="space-y-6">
                @csrf
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Brand Code</label>
                    <input name="code" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300" />
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Brand Name</label>
                    <input name="name" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300" />
                </div>
                

                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="hideAddMerkForm()" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl font-medium transition-all duration-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-xl font-medium transition-all duration-300 shadow-lg">
                        Add Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Brand Form -->
<div id="editMerkForm" class="hidden fixed inset-0 bg-black/40 backdrop-blur-sm flex justify-center items-start overflow-auto pt-10 z-50">
    <div class="bg-white rounded-2xl w-full max-w-lg mx-4 my-8 shadow-2xl border border-white/20">
        <div class="p-8">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-2xl font-bold bg-gradient-to-r from-purple-600 to-violet-600 bg-clip-text text-transparent">Edit Brand</h2>
                <button onclick="hideEditMerkForm()" class="p-2 hover:bg-slate-100 rounded-lg transition-colors duration-200">
                    <i class="fas fa-times text-slate-400"></i>
                </button>
            </div>
            <form method="POST" id="editMerkFormContent" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Brand Code</label>
                    <input name="code" readonly class="w-full border border-slate-300 rounded-xl px-4 py-3 bg-slate-100 cursor-not-allowed" />
                </div>
                
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Brand Name</label>
                    <input name="name" required class="w-full border border-slate-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-purple-500 focus:border-transparent transition-all duration-300" />
                </div>
                
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" onclick="hideEditMerkForm()" class="px-6 py-3 bg-slate-200 hover:bg-slate-300 text-slate-700 rounded-xl font-medium transition-all duration-300">
                        Cancel
                    </button>
                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-purple-500 to-purple-600 hover:from-purple-600 hover:to-purple-700 text-white rounded-xl font-medium transition-all duration-300 shadow-lg">
                        Update Brand
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function showEditMerkForm(merk) {
        const formWrapper = document.getElementById('editMerkForm');
        const form = document.getElementById('editMerkFormContent');

        form.action = `/admin/brand/${merk.code}`;

        form.querySelector('input[name="code"]').value = merk.code;
        form.querySelector('input[name="name"]').value = merk.name;

        formWrapper.classList.remove('hidden');
    }

    function hideAddMerkForm() {
        document.getElementById('addMerkForm').classList.add('hidden');
    }

    function hideEditMerkForm() {
        document.getElementById('editMerkForm').classList.add('hidden');
    }
</script>
