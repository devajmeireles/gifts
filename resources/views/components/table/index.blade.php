<div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
    <table class="min-w-full divide-y divide-gray-300">
        {{ $slot }}
    </table>
    {{ $items->links() }}
</div>
