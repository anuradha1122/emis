<div class="w-full grid grid-cols-1 gap-y-1 sm:grid-cols-2">
    <div class="sm:col-span-1 px-1">
        <x-form-input-label for="province" value="Province" />
        <x-form-list-input-field name="province" id="province" :options="$provinceList" wire:model.live="selectedProvince"/>
    </div>
    <div class="sm:col-span-1 px-1">
        <x-form-input-label for="district" value="District" />
        <x-form-list-input-field name="district" id="district" :options="$districtList" wire:model.live="selectedDistrict"/>
    </div>
    <div class="sm:col-span-1 px-1">
        <x-form-input-label for="zone" value="Zone" />
        <x-form-list-input-field name="zone" id="zone" :options="$zoneList" wire:model.live="selectedZone"/>
    </div>
    <div class="sm:col-span-1 px-1">
        <x-form-input-label for="division" value="Division" />
        <x-form-list-input-field name="division" id="division" :options="$divisionList" wire:model.live="selectedDivision"/>
    </div>
    <div class="sm:col-span-1 px-1">
        <x-form-input-label for="school" value="School" />
        <x-form-list-input-field name="school" id="school" :options="$schoolList"/>
    </div>
</div>
