<div class="grid grid-cols-1 sm:grid-cols-[1fr_20rem_1fr] gap-3 w-full items-center">

    <div class="sm:col-start-2 sm:row-start-1 flex justify-center">
        <x-admin.admin-inputs placeholder="Bild-weiter" model="forward_id" />
    </div>
    <div class="sm:col-start-1 sm:row-start-2 flex justify-center sm:justify-end">
        <x-admin.admin-inputs placeholder="Bild-links" model="left_id" />
    </div>

    <div class="sm:col-start-2 sm:row-start-2 flex justify-center">
        <div class="w-full max-w-80">
            <x-admin.image-viewer :preview-url="$previewUrl" />
        </div>
    </div>


    <div class="sm:col-start-3 sm:row-start-2 flex justify-center sm:justify-start">
        <x-admin.admin-inputs placeholder="Bild-rechts" model="right_id" />
    </div>
    <div class="sm:col-start-2 sm:row-start-3 flex justify-center">
        <x-admin.admin-inputs placeholder="Bild-unten" model="back_id" />
    </div>

</div>
