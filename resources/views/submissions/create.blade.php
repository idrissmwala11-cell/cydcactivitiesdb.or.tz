<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Program Day - ' . ucwords(str_replace('_', ' ', $section))) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <!-- Back Button -->
            <div class="mb-6">
                <a href="{{ route('submissions.dashboard') }}" 
                   class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Back to Dashboard
                </a>
            </div>

            <!-- Form Card -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Section Header -->
                    <div class="flex items-center mb-6">
                        @php
                            $sectionConfig = [
                                'masomo_ya_mtaala' => ['icon' => 'book-open', 'color' => 'blue', 'title' => 'Curriculum Studies'],
                                'fani' => ['icon' => 'cog', 'color' => 'green', 'title' => 'Fani'],
                                'special_program' => ['icon' => 'star', 'color' => 'purple', 'title' => 'Special Program'],
                                'parents' => ['icon' => 'users', 'color' => 'orange', 'title' => 'Parents'],
                                'vikoba' => ['icon' => 'currency-dollar', 'color' => 'indigo', 'title' => 'Vikoba']
                            ];
                            $config = $sectionConfig[$section] ?? ['icon' => 'document', 'color' => 'gray', 'title' => ucwords(str_replace('_', ' ', $section))];
                        @endphp
                        
                        <div class="bg-{{ $config['color'] }}-600 text-white p-3 rounded-lg mr-4">
                            @if($config['icon'] === 'book-open')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            @elseif($config['icon'] === 'cog')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            @elseif($config['icon'] === 'star')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path>
                                </svg>
                            @elseif($config['icon'] === 'users')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                            @elseif($config['icon'] === 'currency-dollar')
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            @else
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $config['title'] }}</h3>
                            <p class="text-gray-600">Fill out the form below for this program section</p>
                        </div>
                    </div>

                    <!-- Status Alert -->
                    @if($submission && $submission->status !== 'draft')
                        <div class="mb-6 p-4 rounded-lg 
                            {{ $submission->status === 'submitted' ? 'bg-blue-50 border border-blue-200' : 
                               ($submission->status === 'approved' ? 'bg-green-50 border border-green-200' : 'bg-red-50 border border-red-200') }}">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    @if($submission->status === 'submitted')
                                        <svg class="h-5 w-5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"></path>
                                        </svg>
                                    @elseif($submission->status === 'approved')
                                        <svg class="h-5 w-5 text-green-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path>
                                        </svg>
                                    @else
                                        <svg class="h-5 w-5 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"></path>
                                        </svg>
                                    @endif
                                </div>
                                <div class="ml-3">
                                    <p class="text-sm font-medium 
                                        {{ $submission->status === 'submitted' ? 'text-blue-800' : 
                                           ($submission->status === 'approved' ? 'text-green-800' : 'text-red-800') }}">
                                        @if($submission->status === 'submitted')
                                            This form has been submitted and is under review.
                                        @elseif($submission->status === 'approved')
                                            This form has been approved by the administrator.
                                        @else
                                            This form has been rejected. Please review the feedback and resubmit.
                                        @endif
                                    </p>
                                    @if($submission->admin_notes)
                                        <p class="mt-1 text-sm 
                                            {{ $submission->status === 'submitted' ? 'text-blue-700' : 
                                               ($submission->status === 'approved' ? 'text-green-700' : 'text-red-700') }}">
                                            <strong>Admin Notes:</strong> {{ $submission->admin_notes }}
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form -->
                    <form method="POST" action="{{ route('submissions.store') }}" class="space-y-6">
                        @csrf
                        <input type="hidden" name="section_type" value="{{ $section }}">
                        <input type="hidden" name="program_type" value="program_day">
                        @if($submission)
                            <input type="hidden" name="submission_id" value="{{ $submission->id }}">
                        @endif

                        @if($section !== 'vikoba')
                        <!-- Placeholder Form Content -->
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-8 text-center">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900">Form Template Placeholder</h3>
                            <p class="mt-1 text-sm text-gray-500">
                                This is a placeholder for the {{ $config['title'] }} form.<br>
                                The actual form fields will be provided later.
                            </p>
                            
                            <!-- Sample Input Field -->
                            <div class="mt-6 max-w-md mx-auto">
                                <label for="sample_input" class="block text-sm font-medium text-gray-700 text-left mb-2">
                                    Sample Input Field
                                </label>
                                <input type="text" 
                                       id="sample_input" 
                                       name="form_data[sample_input]" 
                                       value="{{ old('form_data.sample_input', $submission->form_data['sample_input'] ?? '') }}"
                                       class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                       placeholder="Enter sample data...">
                            </div>
                            
                            <!-- Sample Textarea -->
                            <div class="mt-4 max-w-md mx-auto">
                                <label for="sample_textarea" class="block text-sm font-medium text-gray-700 text-left mb-2">
                                    Sample Description
                                </label>
                                <textarea id="sample_textarea" 
                                          name="form_data[sample_textarea]" 
                                          rows="3"
                                          class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500"
                                          placeholder="Enter description...">{{ old('form_data.sample_textarea', $submission->form_data['sample_textarea'] ?? '') }}</textarea>
                            </div>
                        </div>
                        @endif

                        @if($section === 'vikoba')
                            @php
                                $fd = $submission->form_data ?? [];
                                $membersOld = old('form_data.members');
                                $members = is_array($membersOld) ? $membersOld : ($fd['members'] ?? [[ 'name' => '', 'phone' => '' ]]);
                            @endphp
                            <div class="rounded-lg border border-{{ $config['color'] }}-200 p-6 bg-{{ $config['color'] }}-50/30">
                                <h3 class="text-center text-lg font-semibold text-gray-800 mb-6">SAVING GROUPS INFORMATION FORM</h3>

                                <div class="space-y-5">
                                    <!-- 1. Group Name -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">1. Group Name <span class="text-red-500">*</span></label>
                                        <input type="text" name="form_data[jina_la_kikundi]" value="{{ old('form_data.jina_la_kikundi', $fd['jina_la_kikundi'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-{{ $config['color'] }}-500 focus:border-{{ $config['color'] }}-500" placeholder="Ingiza jina la kikundi" />
                                        @error('form_data.jina_la_kikundi')
                                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- 2. Idadi ya Wanachama -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">2. Idadi ya Wanachama <span class="text-red-500">*</span></label>
                                        <input type="number" min="1" name="form_data[idadi_ya_wanachama]" value="{{ old('form_data.idadi_ya_wanachama', $fd['idadi_ya_wanachama'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-{{ $config['color'] }}-500 focus:border-{{ $config['color'] }}-500" placeholder="Mf. 15" />
                                    </div>

                                    <!-- 3. Miezi wa Kikundi -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">3. Miezi wa Kikundi <span class="text-red-500">*</span></label>
                                        <input type="text" name="form_data[miezi_wa_kikundi]" value="{{ old('form_data.miezi_wa_kikundi', $fd['miezi_wa_kikundi'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-{{ $config['color'] }}-500 focus:border-{{ $config['color'] }}-500" placeholder="Mf. 12" />
                                    </div>

                                    <!-- 4. Kimesajiliwa au Hakijasajiliwa? -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">4. Kimesajiliwa au Hakijasajiliwa? <span class="text-red-500">*</span></label>
                                        <div class="flex items-center space-x-6">
                                            <label class="inline-flex items-center">
                                                <input type="radio" class="form-radio text-{{ $config['color'] }}-600" name="form_data[kimesajiliwa]" value="kimesajiliwa" {{ old('form_data.kimesajiliwa', $fd['kimesajiliwa'] ?? '') === 'kimesajiliwa' ? 'checked' : '' }}>
                                                <span class="ml-2">Kimesajiliwa</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" class="form-radio text-{{ $config['color'] }}-600" name="form_data[kimesajiliwa]" value="hakijasajiliwa" {{ old('form_data.kimesajiliwa', $fd['kimesajiliwa'] ?? '') === 'hakijasajiliwa' ? 'checked' : '' }}>
                                                <span class="ml-2">Hakijasajiliwa</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- 5. Kiwango cha Pesa (TZS) -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">5. Kiwango cha Pesa (TZS) <span class="text-red-500">*</span></label>
                                        <input type="number" min="0" step="1000" name="form_data[kiwango_cha_pesa]" value="{{ old('form_data.kiwango_cha_pesa', $fd['kiwango_cha_pesa'] ?? '') }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-{{ $config['color'] }}-500 focus:border-{{ $config['color'] }}-500" placeholder="Mf. 50000" />
                                    </div>

                                    <!-- 6. Wana Akaunti ya Benki? -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">6. Wana Akaunti ya Benki? <span class="text-red-500">*</span></label>
                                        <div class="flex items-center space-x-6">
                                            <label class="inline-flex items-center">
                                                <input type="radio" class="form-radio text-{{ $config['color'] }}-600" name="form_data[wana_akaunti_ya_benki]" value="ndiyo" {{ old('form_data.wana_akaunti_ya_benki', $fd['wana_akaunti_ya_benki'] ?? '') === 'ndiyo' ? 'checked' : '' }}>
                                                <span class="ml-2">Yes</span>
                                            </label>
                                            <label class="inline-flex items-center">
                                                <input type="radio" class="form-radio text-{{ $config['color'] }}-600" name="form_data[wana_akaunti_ya_benki]" value="hapana" {{ old('form_data.wana_akaunti_ya_benki', $fd['wana_akaunti_ya_benki'] ?? '') === 'hapana' ? 'checked' : '' }}>
                                                <span class="ml-2">No</span>
                                            </label>
                                        </div>
                                    </div>

                                    <!-- 7. Maendeleo ya Kikundi -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-1">7. Maendeleo ya Kikundi</label>
                                        <textarea name="form_data[maendeleo_ya_kikundi]" rows="4" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-{{ $config['color'] }}-500 focus:border-{{ $config['color'] }}-500" placeholder="Eleza kwa kifupi maendeleo ya kikundi">{{ old('form_data.maendeleo_ya_kikundi', $fd['maendeleo_ya_kikundi'] ?? '') }}</textarea>
                                    </div>

                                    <!-- 8. Orodhesha Majina ya Wanakikundi -->
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-3">8. Orodhesha Majina ya Wanakikundi <span class="text-red-500">*</span></label>
                                        <div class="overflow-hidden border rounded-lg">
                                            <div class="bg-{{ $config['color'] }}-600 text-white px-4 py-2 font-semibold grid grid-cols-12 gap-2">
                                                <div class="col-span-1">#</div>
                                                <div class="col-span-6">Jina Kamili</div>
                                                <div class="col-span-4">Phone Number</div>
                                                <div class="col-span-1"></div>
                                            </div>
                                            <div id="members-list" class="divide-y">
                                                @foreach($members as $idx => $m)
                                                    <div class="grid grid-cols-12 gap-2 p-2 items-center">
                                                        <div class="col-span-1 text-sm text-gray-600">{{ $idx + 1 }}</div>
                                                        <div class="col-span-6">
                                                            <input type="text" name="form_data[members][{{ $idx }}][name]" value="{{ $m['name'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-{{ $config['color'] }}-500 focus:border-{{ $config['color'] }}-500" placeholder="Jina kamili" />
                                                        </div>
                                                        <div class="col-span-4">
                                                            <input type="text" name="form_data[members][{{ $idx }}][phone]" value="{{ $m['phone'] ?? '' }}" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-{{ $config['color'] }}-500 focus:border-{{ $config['color'] }}-500" placeholder="07XXXXXXXX" />
                                                        </div>
                                                        <div class="col-span-1 text-right">
                                                            <button type="button" class="remove-member text-red-600 hover:text-red-800" aria-label="Remove">&times;</button>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                        <button type="button" id="add-member" class="mt-3 inline-flex items-center px-3 py-2 bg-{{ $config['color'] }}-600 text-white rounded-md hover:bg-{{ $config['color'] }}-700">
                                            Ongeza Mwanachama
                                        </button>
                                        <template id="member-row-template">
                                            <div class="grid grid-cols-12 gap-2 p-2 items-center">
                                                <div class="col-span-1 text-sm text-gray-600 row-number"></div>
                                                <div class="col-span-6">
                                                    <input type="text" name="__NAME__" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-{{ $config['color'] }}-500 focus:border-{{ $config['color'] }}-500" placeholder="Jina kamili" />
                                                </div>
                                                <div class="col-span-4">
                                                    <input type="text" name="__PHONE__" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-{{ $config['color'] }}-500 focus:border-{{ $config['color'] }}-500" placeholder="07XXXXXXXX" />
                                                </div>
                                                <div class="col-span-1 text-right">
                                                    <button type="button" class="remove-member text-red-600 hover:text-red-800" aria-label="Remove">&times;</button>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>

                            <script>
                                (function(){
                                    const list = document.getElementById('members-list');
                                    const addBtn = document.getElementById('add-member');
                                    const tpl = document.getElementById('member-row-template');
                                    function updateRowNumbers(){
                                        const rows = list.querySelectorAll('.grid');
                                        rows.forEach((row, i) => {
                                            const numEl = row.querySelector('.row-number');
                                            if (numEl) numEl.textContent = i + 1;
                                        });
                                    }
                                    function bindRemove(row){
                                        const btn = row.querySelector('.remove-member');
                                        if(btn){ btn.addEventListener('click', ()=>{ row.remove(); updateRowNumbers(); }); }
                                    }
                                    list.querySelectorAll('.grid').forEach(bindRemove);
                                    addBtn?.addEventListener('click', () => {
                                        const index = list.querySelectorAll('.grid').length;
                                        const clone = tpl.content.cloneNode(true);
                                        const nameInput = clone.querySelector('input[name="__NAME__"]');
                                        const phoneInput = clone.querySelector('input[name="__PHONE__"]');
                                        nameInput.name = `form_data[members][${index}][name]`;
                                        phoneInput.name = `form_data[members][${index}][phone]`;
                                        list.appendChild(clone);
                                        updateRowNumbers();
                                        // bind remove on newly added row
                                        const newRow = list.lastElementChild;
                                        bindRemove(newRow);
                                    });
                                })();
                            </script>
                        @endif

                        <!-- Form Actions -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <div class="flex space-x-3">
                                <button type="submit" 
                                        name="action" 
                                        value="save_draft"
                                        class="inline-flex items-center px-4 py-2 bg-gray-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring ring-gray-300 disabled:opacity-25 transition ease-in-out duration-150">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3-3m0 0l-3 3m3-3v12"></path>
                                    </svg>
                                    Save as Draft
                                </button>
                                
                                @if(!$submission || $submission->status === 'draft' || $submission->status === 'rejected')
                                    <button type="submit" 
                                            name="action" 
                                            value="submit"
                                            class="inline-flex items-center px-4 py-2 bg-{{ $config['color'] }}-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-{{ $config['color'] }}-700 active:bg-{{ $config['color'] }}-900 focus:outline-none focus:border-{{ $config['color'] }}-900 focus:ring ring-{{ $config['color'] }}-300 disabled:opacity-25 transition ease-in-out duration-150">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path>
                                        </svg>
                                        Submit for Review
                                    </button>
                                @endif
                            </div>
                            
                            @if($submission && $submission->status === 'draft')
                                <form method="POST" action="{{ route('submissions.destroy', $submission) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" 
                                            class="inline-flex items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-700 active:bg-red-900 focus:outline-none focus:border-red-900 focus:ring ring-red-300 disabled:opacity-25 transition ease-in-out duration-150"
                                            onclick="return confirm('Are you sure you want to delete this draft?')">
                                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Delete Draft
                                    </button>
                                </form>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
