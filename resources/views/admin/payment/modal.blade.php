<div class="modal fade" id="TypePayment-modal">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title"></h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="addEditTypePaymentForm" action="javascript:void(0)" method="POST">
                    @csrf
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" class="form-control" name="nama" id="nama" placeholder="Nama">
                        <span class="text-danger" id="namaError"></span>
                    </div>
                    <div class="form-group">
                        <label for="nominal">Nominal</label>
                        <input type="text" class="form-control" name="nominal" id="nominal" placeholder="nominal">
                        <span class="text-danger" id="nominalError"></span>
                    </div>
                    <button type="button" class="btn btn-primary" id="btn-save">Simpan</button>
                </form>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
