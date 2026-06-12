@csrf

<div class="card border-0 shadow-sm mb-4">
    <div class="card-header bg-primary text-white">
        <h6 class="mb-0">LOCAL SPONSORSHIP REGISTRATION</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label for="child_name" class="form-label">1. Child's Name <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('child_name') is-invalid @enderror" id="child_name" name="child_name" value="{{ old('child_name', $localSponsorship->child_name ?? '') }}" required>
                @error('child_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="child_age" class="form-label">2. Child's Age <span class="text-danger">*</span></label>
                <input type="number" class="form-control @error('child_age') is-invalid @enderror" id="child_age" name="child_age" value="{{ old('child_age', $localSponsorship->child_age ?? '') }}" min="0" required>
                @error('child_age') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="child_location" class="form-label">3. Location Where the Child is Found <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('child_location') is-invalid @enderror" id="child_location" name="child_location" value="{{ old('child_location', $localSponsorship->child_location ?? '') }}" required>
                @error('child_location') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="local_number" class="form-label">4. Child's Local Number <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('local_number') is-invalid @enderror" id="local_number" name="local_number" value="{{ old('local_number', $localSponsorship->local_number ?? '') }}" required>
                @error('local_number') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="sponsor_type" class="form-label">5. Local Sponsor Type <span class="text-danger">*</span></label>
                <select class="form-select @error('sponsor_type') is-invalid @enderror" id="sponsor_type" name="sponsor_type" required>
                    <option value="">-- Select sponsor type --</option>
                    <option value="Church" @selected(old('sponsor_type', $localSponsorship->sponsor_type ?? '') === 'Church')>Church</option>
                    <option value="Group" @selected(old('sponsor_type', $localSponsorship->sponsor_type ?? '') === 'Group')>Group</option>
                    <option value="Individual" @selected(old('sponsor_type', $localSponsorship->sponsor_type ?? '') === 'Individual')>Individual</option>
                </select>
                @error('sponsor_type') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-6">
                <label for="sponsor_name" class="form-label">6. Name of the Local Sponsor <span class="text-danger">*</span></label>
                <input type="text" class="form-control @error('sponsor_name') is-invalid @enderror" id="sponsor_name" name="sponsor_name" value="{{ old('sponsor_name', $localSponsorship->sponsor_name ?? '') }}" required>
                @error('sponsor_name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>
        </div>
    </div>
</div>

<div class="d-flex justify-content-end gap-2">
    <a href="{{ route('local-sponsorship.index') }}" class="btn btn-secondary">
        <i class="bi bi-arrow-left-circle me-1"></i> Back
    </a>
    <button type="submit" class="btn btn-primary">
        <i class="bi bi-check-circle me-1"></i> Save Record
    </button>
</div>
