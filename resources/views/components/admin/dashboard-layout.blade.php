<div class="bg-gray-200  h-full w-full">

    <x-admin.admin-header />

    <div class="flex flex-col lg:flex-row gap-6 mt-6">

        <div class="w-full lg:w-auto shrink-0">
            <x-admin.image-sidebar :images="$nodes" />
        </div>

        <div class="flex-1">
            <x-admin.image-navigation :nodes="$nodes" :previewUrl="$previewUrl" />
        </div>

    </div>

    <div class="mt-6">
        <x-admin.admin-actions />
        <x-admin.admin-button text="Startbild" action="saveStart" :color="$start ? 'bg-green-700 text-white' : 'bg-gray-600 text-black'" />
    </div>

</div>
