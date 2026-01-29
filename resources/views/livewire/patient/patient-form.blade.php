<form wire:submit.prevent="save">
    <input class="form-control mb-2" wire:model="form.first_name" placeholder="First Name">
    <input class="form-control mb-2" wire:model="form.last_name" placeholder="Last Name">

    <select class="form-control mb-2" wire:model="form.gender">
        <option value="">Gender</option>
        <option value="male">Male</option>
        <option value="female">Female</option>
    </select>

    <input class="form-control mb-2" wire:model="form.phone" placeholder="Phone">

    <button class="btn btn-success">Save</button>
</form>
