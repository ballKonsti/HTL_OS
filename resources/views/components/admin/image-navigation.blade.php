<div class="grid grid-cols-[1fr_20rem_1fr] grid-rows-[auto_20rem_auto] gap-3 w-full items-center">

    <div class="col-start-2 row-start-1 flex justify-center">
        <x-admin.admin-inputs 
        placeholder="Bild-weiter"
        model="imageForward" />
    </div>
    <div class="col-start-1 row-start-2 flex justify-end">
        <x-admin.admin-inputs 
        placeholder="Bild-links" 
        model="imageLeft"/>
    </div>

   
    <div class="col-start-2 row-start-2 flex justify-center">
        <x-admin.image-viewer />
    </div>

   
    <div class="col-start-3 row-start-2 flex justify-start">
        <x-admin.admin-inputs 
        placeholder="Bild-rechts"
        model="imageRight" />
    </div>


    <div class="col-start-2 row-start-3 flex justify-center">
        <x-admin.admin-inputs 
        placeholder="Bild-unten"
        model="imageBack" />
    </div>

</div>