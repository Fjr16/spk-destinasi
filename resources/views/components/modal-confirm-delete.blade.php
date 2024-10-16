<div class="modal fade" id="modalDelete" aria-labelledby="modalToggleLabel" tabindex="-1" style="display: none;" aria-hidden="true">
<div class="modal-dialog modal-sm">
    <div class="modal-content">
    <div class="modal-body pb-0">
        <h5 class="text-center">
            {{ $slot }}
        </h5>
    </div>
    <div class="modal-footer justify-content-center">
        <button class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
        <form action="" method="POST" id="formDelete">
            @csrf
            @method('DELETE')
            <button class="btn btn-primary" type="submit" data-bs-dismiss="modal">Yakin</button>
        </form>
    </div>
    </div>
</div>
</div>