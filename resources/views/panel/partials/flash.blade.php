@if(session('basari'))
    <div class="mb-6 flex items-start gap-3 bg-success/10 border border-success/30 text-success rounded-xl px-4 py-3">
        <span class="material-symbols-outlined">check_circle</span>
        <div class="text-sm">{!! session('basari') !!}</div>
    </div>
@endif

@if($errors->any())
    <div class="mb-6 flex items-start gap-3 bg-error/10 border border-error/30 text-error rounded-xl px-4 py-3">
        <span class="material-symbols-outlined">error</span>
        <div class="text-sm">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $hata)
                    <li>{{ $hata }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif
