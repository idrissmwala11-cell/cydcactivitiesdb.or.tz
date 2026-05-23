<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Masomo ya Fani') }}
        </h2>
    </x-slot>

    <!-- Scoped styles for this page only -->
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Outfit:wght@400;700&display=swap');

        .fani-page { font-family: 'Outfit', system-ui, -apple-system, Segoe UI, Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji"; position: relative; }
        .fani-page .form-container { background-color: #e0e0e0; border: 2px solid #1e90ff; border-radius: 10px; max-width: 800px; margin: 30px auto; padding: 20px; }
        .fani-page .form-container h2 { text-align: center; color: #2c3e50; margin-top: 0; text-transform: uppercase; letter-spacing: .05em; }
        .fani-page .form-group { margin-bottom: 15px; }
        .fani-page .form-group label { display: block; margin-bottom: 6px; font-weight: 700; color: #1f2937; }
        .fani-page .form-group input, .fani-page .form-group textarea { width: 100%; padding: 10px 12px; border: 1px solid #cbd5e1; border-radius: 6px; box-sizing: border-box; background: #fff; }
        .fani-page .form-group input:focus, .fani-page .form-group textarea:focus { outline: none; border-color: #1e90ff; box-shadow: 0 0 0 3px rgba(30,144,255,.15); }
        .fani-page .form-group textarea { min-height: 90px; resize: vertical; }
        .fani-page .submit-btn { background-color: #1e90ff; color: #fff; border: none; padding: 12px 22px; border-radius: 8px; cursor: pointer; font-weight: 700; display: block; margin: 22px auto 0; transition: background-color .25s, transform .15s; }
        .fani-page .submit-btn:hover { background-color: #187bcd; transform: translateY(-1px); }
        .fani-page .submit-btn:active { transform: translateY(0); }

        /* Animated banner message */
        .fani-page .message { background: linear-gradient(45deg, #a8d8ea, #aa96da); color: #000; display: block; font-weight: 700; overflow: hidden; position: absolute; padding: 0.2rem 1rem; top: 0.2rem; left: 270px; border-radius: 4px; animation: openclose 8s ease-in-out infinite; height: 4.5rem; cursor: pointer; transition: transform 0.3s ease, box-shadow 0.3s ease; }
        .fani-page .message:hover { transform: scale(1.02); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
        .fani-page .word1, .fani-page .word2, .fani-page .word3, .fani-page .word4 { font-family: tahoma, sans-serif; position: absolute; width: 100%; opacity: 0; height: 4.5rem; line-height: 4.5rem; }
        .fani-page .message .word1 { animation: word-animation 8s infinite; }
        .fani-page .message .word2 { animation: word-animation 8s infinite 2s; }
        .fani-page .message .word3 { animation: word-animation 8s infinite 4s; }
        .fani-page .message .word4 { animation: word-animation 8s infinite 6s; }
        @keyframes word-animation { 0%, 5% { opacity: 0; } 10%, 22% { opacity: 1; } 27%, 100% { opacity: 0; } }
        @keyframes openclose { 0% { top: 0.2rem; width: 0; } 5% { width: 0; } 10% { width: 285px; } 20% { top: 0.2rem; width: 285px; } 25% { top: 0.2rem; width: 0; } 30% { top: 0.2rem; width: 0; } 35% { top: 0.2rem; width: 285px; } 45% { top: 0.2rem; width: 285px; } 50% { top: 0.2rem; width: 0; } 55% { top: 0.2rem; width: 0; } 60% { top: 0.2rem; width: 285px; } 70% { top: 0.2rem; width: 285px; } 75% { top: 0.2rem; width: 0; } 80% { top: 0.2rem; width: 285px; } 90% { top: 0.2rem; width: 285px; } 95% { top: 0.2rem; width: 0; } 100% { top: 0.2rem; width: 0; } }

        /* Optional footer styles scaffold (not used elsewhere) */
        .fani-page .footer { background-color: #2c3e50; color: #fff; padding: 40px 20px; margin-top: 24px; border-radius: 10px; }
        .fani-page .footer .footer-container { max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 30px; }
        .fani-page .footer .footer-column h3 { color: #1e90ff; margin: 0 0 8px; }
    </style>

    <div class="py-8 fani-page">
        <!-- Animated rotating message banner -->
        <div class="message" title="Masomo ya Fani">
            <span class="word1">MASOMO YA FANI</span>
            <span class="word2">JAZA FOMU YA LEO</span>
            <span class="word3">HIFADHI AU WASILISHA</span>
            <span class="word4">ASANTE!</span>
        </div>

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

            <!-- MASOMO YA FANI Form -->
            <div class="form-container">
                <h2>MASOMO YA FANI</h2>
                <form method="POST" action="{{ route('submissions.masomo-ya-fani.store') }}">
                    @csrf

                    <div class="form-group">
                        <label for="tarehe_aliyofundisha">1. TAREHE ALIYOFUNDISHA:</label>
                        <input type="date" id="tarehe_aliyofundisha" name="tarehe_aliyofundisha" value="{{ old('tarehe_aliyofundisha', $existingSubmission->date ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="jina_la_mwalimu">2. JINA LA MWALIMU :</label>
                        <input type="text" id="jina_la_mwalimu" name="jina_la_mwalimu" value="{{ old('jina_la_mwalimu', $existingSubmission->teacher ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="fani_anayofundisha">3. FANI ANAYOFUNDISHA :</label>
                        <input type="text" id="fani_anayofundisha" name="fani_anayofundisha" value="{{ old('fani_anayofundisha', $existingSubmission->fani_type ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="mada_aliyo_fundisha">4. MADA ALIYO FUNDISHA:</label>
                        <input type="text" id="mada_aliyo_fundisha" name="mada_aliyo_fundisha" value="{{ old('mada_aliyo_fundisha', $existingSubmission->topic ?? '') }}" required>
                    </div>

                    <div class="form-group">
                        <label for="washiriki_wanapendelea_nini_kwenye_fani_yake">5. WASHIRIKI WANAPENDELEA NINI KWENYE FANI YAKE :</label>
                        <textarea id="washiriki_wanapendelea_nini_kwenye_fani_yake" name="washiriki_wanapendelea_nini_kwenye_fani_yake" required>{{ old('washiriki_wanapendelea_nini_kwenye_fani_yake', $existingSubmission->student_preferences ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="maoni_ya_mwanafunzi">6. MAONI YA MWANAFUNZI :</label>
                        <textarea id="maoni_ya_mwanafunzi" name="maoni_ya_mwanafunzi">{{ old('maoni_ya_mwanafunzi', $existingSubmission->student_feedback ?? '') }}</textarea>
                    </div>

                    <div class="form-group">
                        <label for="maoni_ya_mwalimu">7. MAONI YA MWALIMU :</label>
                        <textarea id="maoni_ya_mwalimu" name="maoni_ya_mwalimu">{{ old('maoni_ya_mwalimu', $existingSubmission->teacher_feedback ?? '') }}</textarea>
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