<x-app-layout>
    <div class="container">
        <h3 class="text-center mt-5 mb-3">Laravel SHA-256 Encryption</h3>
        <div class="card">
            <div class="card-body">
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="private-key-tab" data-bs-toggle="tab"
                            data-bs-target="#private-key-tab-pane" type="button" role="tab"
                            aria-controls="private-key-tab-pane" aria-selected="true">Generate Private Key</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="public-key-tab" data-bs-toggle="tab"
                            data-bs-target="#public-key-tab-pane" type="button" role="tab"
                            aria-controls="public-key-tab-pane" aria-selected="false">Generate Public Key</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="encrypt-tab" data-bs-toggle="tab"
                            data-bs-target="#encrypt-tab-pane" type="button" role="tab"
                            aria-controls="encrypt-tab-pane" aria-selected="false">Encrypt</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" id="decrypt-tab" data-bs-toggle="tab"
                            data-bs-target="#decrypt-tab-pane" type="button" role="tab"
                            aria-controls="decrypt-tab-pane" aria-selected="false">Decrypt</button>
                    </li>
                </ul>
                <div class="tab-content pt-3" id="myTabContent">
                    <div class="tab-pane fade show active" id="private-key-tab-pane" role="tabpanel"
                        aria-labelledby="private-key-tab" tabindex="0">
                        @session('error')
                            <div class="alert alert-danger" role="alert">
                                {{ $value }}
                            </div>
                        @endsession

                        <form action="{{ route('generatePrivateKey') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Digest Alg</label>
                                <input type="text" name="digest_alg" placeholder="Digest Alg"
                                    value="{{ $digest_alg }}" @class(['form-control', 'is-invalid' => $errors->has('digest_alg')]) required>
                                @error('digest_alg')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Private Key Bits</label>
                                <input type="number" name="private_key_bits" placeholder="Private Key Bits"
                                    value="{{ $private_key_bits }}" @class([
                                        'form-control',
                                        'is-invalid' => $errors->has('private_key_bits'),
                                    ]) required>
                                @error('private_key_bits')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Private Key Type</label>
                                <input type="text" class="form-control" value="{{ $private_key_type }}" readonly>
                            </div>
                            <div class="text-end">
                                <button type="reset" class="btn btn-light border">Reset</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" id="public-key-tab-pane" role="tabpanel" aria-labelledby="public-key-tab"
                        tabindex="0">...</div>
                    <div class="tab-pane fade" id="encrypt-tab-pane" role="tabpanel" aria-labelledby="encrypt-tab"
                        tabindex="0">...</div>
                    <div class="tab-pane fade" id="decrypt-tab-pane" role="tabpanel" aria-labelledby="decrypt-tab"
                        tabindex="0">...</div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
