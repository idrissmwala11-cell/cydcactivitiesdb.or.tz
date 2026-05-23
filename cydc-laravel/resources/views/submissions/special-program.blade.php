<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Special Program') }}
        </h2>
    </x-slot>

    <!-- Scoped styles for this page only -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap');

        .sp-page { font-family: 'Outfit', system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji"; position: relative; }
        .sp-page .form-container { background-color: #e0e0e0; border: 2px solid #6b21a8; border-radius: 10px; max-width: 800px; margin: 30px auto; padding: 20px; }
        .sp-page .form-container h2 { text-align: center; color: #2c3e50; margin-top: 0; text-transform: uppercase; letter-spacing: .05em; }
        .sp-page .form-group { margin-bottom: 15px; }
        .sp-page .form-group label { display: block; margin-bottom: 6px; font-weight: 700; color: #1f2937; }
        .sp-page .form-group input, .sp-page .form-group textarea { width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; background: #fff; }
        .sp-page .form-group input:focus, .sp-page .form-group textarea:focus { outline: none; border-color: #7e22ce; box-shadow: 0 0 0 3px rgba(126,34,206,.15); }
        .sp-page .form-group textarea { min-height: 90px; resize: vertical; }
        .sp-page .submit-btn { background-color: #7e22ce; color: #fff; border: none; padding: 12px 22px; border-radius: 8px; cursor: pointer; font-weight: 700; display: block; margin: 22px auto 0; transition: background-color .25s, transform .15s; }
        .sp-page .submit-btn:hover { background-color: #6b21a8; transform: translateY(-1px); }
        .sp-page .submit-btn:active { transform: translateY(0); }
    </style>

    <div class="py-8 sp-page">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Flash messages -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                    <ul class="list-disc list-inside">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- SPECIAL PROGRAM Form -->
            <div class="form-container">
                <h2>SPECIAL PROGRAM</h2>
                <form method="POST" action="{{ route('submissions.special-program.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="date">1. TAREHE ALIYOFUNDISHA :</label>
                        <input type="date" id="date" name="date" value="{{ old('date', data_get($submission, 'form_data.date', '')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="teacher">2. JINA LA ALIYE FUNDISHA :</label>
                        <input type="text" id="teacher" name="teacher" value="{{ old('teacher', data_get($submission, 'form_data.teacher', '')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="topic">3. MADA ALIYO FUNDISHA :</label>
                        <input type="text" id="topic" name="topic" value="{{ old('topic', data_get($submission, 'form_data.topic', '')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="age_range">3. MADA IMEHUSU WASHIRIKI WA KUANZIA MIAKA MINGAPI?:</label>
                        <input type="text" id="age_range" name="age_range" placeholder="Mfano: 12-18 years" value="{{ old('age_range', data_get($submission, 'form_data.age_range', '')) }}" required>
                    </div>

                    <div class="form-group">
                        <label for="teacher_feedback">4. MAONI YA ALIYE FUNDISHA:</label>
                        <textarea id="teacher_feedback" name="teacher_feedback">{{ old('teacher_feedback', data_get($submission, 'form_data.teacher_feedback', '')) }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="supervisor_feedback">5. MAONI YA MSIMAMIZI :</label>
                        <textarea id="supervisor_feedback" name="supervisor_feedback">{{ old('supervisor_feedback', data_get($submission, 'form_data.supervisor_feedback', '')) }}</textarea>
                    </div>

                    <div class="form-group" style="display: flex; gap: 12px; justify-content: center;">
                        <button type="submit" name="action" value="draft" class="submit-btn" style="background-color:#6b7280">Hifadhi Rasimu</button>
                        <button type="submit" name="action" value="submit" class="submit-btn">Wasilisha</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>