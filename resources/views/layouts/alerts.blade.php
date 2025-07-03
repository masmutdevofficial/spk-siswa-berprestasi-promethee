@if(session('success') || session('error') || $errors->any())
    <div aria-live="polite" aria-atomic="true" style="position: fixed; top: 1rem; right: 1rem; z-index: 9999;">
        <div class="toast show text-white
            {{ session('success') ? 'bg-success' : (session('error') || $errors->any() ? 'bg-danger' : '') }}"
            id="liveToast" role="alert" data-delay="3000" style="min-width: 250px;">

            <div class="toast-header {{ session('success') ? 'bg-success text-white' : 'bg-danger text-white' }}">
                <strong class="mr-auto">
                    @if(session('success'))
                        Sukses
                    @else
                        Gagal
                    @endif
                </strong>
                <small>Sekarang</small>
                <button type="button" class="ml-2 mb-1 close text-white" data-dismiss="toast" aria-label="Close" onclick="document.getElementById('liveToast').remove();">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <div class="toast-body">
                {{-- Menampilkan success atau error message --}}
                @if(session('success') || session('error'))
                    {{ session('success') ?? session('error') }}
                @endif

                {{-- Menampilkan semua error dari validator --}}
                @if($errors->any())
                    <ul class="mb-0 pl-3">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>
        </div>
    </div>
@endif
