<div class="bg-red-100 text-red-600 p-4 mb-4 rounded-md inline-block">
    <form action="{{ $action }}" method="POST">
        @csrf
        {{ session('statusDelete') }}
        <input type="hidden" name="id" value="{{ $id }}">
        <button type="submit" class="font-semibold underline">Undo</button>.
    </form>
    {{ $slot }}
</div>
