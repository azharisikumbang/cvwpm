<div x-data="{ open: true }"
    class="flex justify-between items-center p-4 text-sm text-{{ $color }}-800 rounded-lg bg-{{ $color }}-200"
    role="alert" x-show="open">
    <span>{{ $message }}</span>
    <span class="cursor-pointer" @click="open = false">&#10005;</span>
</div>