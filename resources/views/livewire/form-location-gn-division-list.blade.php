<div class="w-full grid grid-cols-1 gap-y-1 sm:grid-cols-2 lg:grid-cols-4">
    <div class="sm:col-span-1 px-1">
        <x-form-input-label for="province" value="Province" />
        <x-form-list-input-field name="province" id="province" :options="$provinceList" wire:model.live="selectedProvince" />
    </div>

    <div class="sm:col-span-1 px-1">
        <x-form-input-label for="district" value="District" />
        <x-form-list-input-field name="district" id="district" :options="$districtList" wire:model.live="selectedDistrict" />
    </div>

    <div class="sm:col-span-1 px-1">
        <x-form-input-label for="dsDivision" value="DS Division" />
        <x-form-list-input-field name="dsDivision" id="dsDivision" :options="$dsDivisionList" wire:model.live="selectedDsDivision" />
    </div>

    <div class="sm:col-span-1 px-1">
        <x-form-input-label for="gnDivision" value="GN Division" />
        <x-form-list-input-field name="gnDivision" id="gnDivision" :options="$gnDivisionList" wire:model.live="selectedGnDivision" />
    </div>
</div>
