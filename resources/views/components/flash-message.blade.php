@session('success')
<div class="w-full">
    <x-alert color="green" :message="$value" />
</div>
@endsession

@if ($errors->any())
<div class="w-full">
    @foreach ($errors->all() as $error)
    <x-alert color="yellow" :message="$error" />
    @endforeach
</div>
@endif