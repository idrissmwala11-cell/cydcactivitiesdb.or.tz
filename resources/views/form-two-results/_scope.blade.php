<form method="GET" class="f2-no-print card card-body border-success mb-3">
    <div class="row g-2 align-items-end">
        <div class="col-md-4">
            <label class="form-label fw-bold">Ngazi ya Shule</label>
            <select class="form-select" name="education_level" id="education-level" onchange="this.form.querySelector('[name=class_level]').value=''; this.form.submit()">
                <option value="primary" @selected($educationLevel === 'primary')>Msingi</option>
                <option value="secondary" @selected($educationLevel === 'secondary')>Sekondari</option>
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label fw-bold">Darasa</label>
            <select class="form-select" name="class_level" onchange="this.form.submit()">
                @foreach($classOptions[$educationLevel] as $option)
                    <option value="{{ $option }}" @selected($classLevel === $option)>{{ $option }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <div class="alert alert-success mb-0 py-2"><strong>Umechagua:</strong> {{ $educationLevel === 'primary' ? 'Msingi' : 'Sekondari' }} / {{ $classLevel }}</div>
        </div>
    </div>
</form>
