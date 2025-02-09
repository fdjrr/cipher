<x-app-layout>
    <div class="container">
        <h3 class="text-center mt-5 mb-3">Laravel SHA-256 Encryption</h3>
        <div class="card shadow" x-data="myTab">
            <div class="card-body">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" :class="{ 'active': selectedTab == 'private-key-tab' }"
                            x-on:click="setTab('private-key-tab')" id="private-key-tab" type="button" role="tab"
                            aria-controls="private-key-tab-pane" aria-selected="true">Generate Private
                            Key</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" :class="{ 'active': selectedTab == 'public-key-tab' }"
                            x-on:click="setTab('public-key-tab')" id="public-key-tab" type="button" role="tab"
                            aria-controls="public-key-tab-pane" aria-selected="false">Generate Public Key</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" :class="{ 'active': selectedTab == 'encrypt-tab' }"
                            x-on:click="setTab('encrypt-tab')" id="encrypt-tab" type="button" role="tab"
                            aria-controls="encrypt-tab-pane" aria-selected="false">Encrypt</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link" :class="{ 'active': selectedTab == 'decrypt-tab' }"
                            x-on:click="setTab('decrypt-tab')" id="decrypt-tab" type="button" role="tab"
                            aria-controls="decrypt-tab-pane" aria-selected="false">Decrypt</button>
                    </li>
                </ul>
                <div class="tab-content pt-3" id="myTabContent">
                    <div class="tab-pane fade" :class="{ 'show active': selectedTab == 'private-key-tab' }"
                        id="private-key-tab-pane" role="tabpanel" aria-labelledby="private-key-tab" tabindex="0">
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
                                    value="{{ $digest_alg }}" @class(['form-control', 'is-invalid' => $errors->has('digest_alg')])>
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
                                    ])>
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
                    <div class="tab-pane fade" :class="{ 'show active': selectedTab == 'public-key-tab' }"
                        id="public-key-tab-pane" role="tabpanel" aria-labelledby="public-key-tab" tabindex="0">
                        @session('error')
                            <div class="alert alert-danger" role="alert">
                                {{ $value }}
                            </div>
                        @endsession
                        <form action="{{ route('generatePublicKey') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Private Key</label>
                                <input type="file" name="private_key" @class(['form-control', 'is-invalid' => $errors->has('private_key')])>
                                @error('private_key')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="text-end">
                                <button type="reset" class="btn btn-light border">Reset</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" :class="{ 'show active': selectedTab == 'encrypt-tab' }"
                        id="encrypt-tab-pane" role="tabpanel" aria-labelledby="encrypt-tab" tabindex="0">
                        @session('error')
                            <div class="alert alert-danger" role="alert">
                                {{ $value }}
                            </div>
                        @endsession
                        <form action="{{ route('encrypt') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Public Key</label>
                                <input type="file" name="public_key" @class(['form-control', 'is-invalid' => $errors->has('public_key')])>
                                @error('public_key')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Plain Text</label>
                                <textarea name="data" id="" cols="30" rows="5" @class(['form-control', 'is-invalid' => $errors->has('data')])></textarea>
                                @error('data')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @session('encrypted')
                                <div class="mb-3">
                                    <label class="form-label">Encrypted Data</label>
                                    <textarea cols="30" rows="5" class="form-control" disabled>{{ $value }}</textarea>
                                </div>
                            @endsession
                            <div class="text-end">
                                <button type="reset" class="btn btn-light border">Reset</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                    <div class="tab-pane fade" :class="{ 'show active': selectedTab == 'decrypt-tab' }"
                        id="decrypt-tab-pane" role="tabpanel" aria-labelledby="decrypt-tab" tabindex="0">
                        @session('error')
                            <div class="alert alert-danger" role="alert">
                                {{ $value }}
                            </div>
                        @endsession
                        <form action="{{ route('decrypt') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Private Key</label>
                                <input type="file" name="private_key" @class(['form-control', 'is-invalid' => $errors->has('private_key')])>
                                @error('private_key')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Encrypted Data</label>
                                <textarea name="data" id="" cols="30" rows="5" @class(['form-control', 'is-invalid' => $errors->has('data')])></textarea>
                                @error('data')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            @session('decrypted')
                                <div class="mb-3">
                                    <label class="form-label">Decrypted Data</label>
                                    <textarea cols="30" rows="5" class="form-control" disabled>{{ $value }}</textarea>
                                </div>
                            @endsession
                            <div class="text-end">
                                <button type="reset" class="btn btn-light border">Reset</button>
                                <button type="submit" class="btn btn-primary">Submit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <p class="text-muted text-sm text-center mt-3">Copyright &copy; {{ date('Y') }} Fadjrir Herlambang.</p>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('myTab', () => ({
                selectedTab: Alpine.$persist('private-key-tab'),
                setTab(tab) {
                    this.selectedTab = tab
                }
            }));
        });
    </script>
</x-app-layout>
