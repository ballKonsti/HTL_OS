<div class="bg-white border border-gray-400 rounded-lg p-3 sm:p-4 md:p-6 min-h-screen w-full">

    <x-admin.admin-header />

    <div class="flex flex-col lg:flex-row gap-6 mt-6">

        <div class="w-full lg:w-auto shrink-0">
            <x-admin.image-sidebar :images="$nodes" />
        </div>

        <div class="flex-1">
            <x-admin.image-navigation :previewUrl="$previewUrl" />
        </div>

    </div>

    <div class="mt-6">
        <x-admin.admin-actions />
    </div>

</div>
