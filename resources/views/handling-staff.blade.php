@extends('crudbooster::admin_template')

@push('head')
<style>
    td {
        vertical-align: middle !important;
    }
</style>
@endpush

@push('bottom')
<script>

function updateTotal() {
    var totalDisplay = $('#totalDisplay');
    var total = $('#total');
    totalDisplay.val(new Intl.NumberFormat("id-ID", {style: "currency", currency: "idr"}).format(total.val()));
}
$(function(){
    updateTotal();
});
</script>
@endpush

@section('content')
  <!-- Your html goes here -->
<form method='post' action='{{CRUDBooster::mainpath('set-reject/'.$row->id)}}'>
    @csrf
    <div class='panel panel-default'>
        <div class='panel-heading'>
            Alasan Penolakan
        </div>
        <div class='panel-body'>
            <div class='form-group'>
                <label>No. Permohonan</label>
                <input type='text' required class='form-control' value='{{$row->document_no}}' readonly disabled/>
            </div>

            <div class='form-group'>
                <label>Jenis Pengujian</label>
                <input type='text' required class='form-control' value='{{$row->type}}' readonly disabled/>
            </div>

            <div class='form-group'>
                <label>Total Biaya</label>
                <input type='text' id="totalDisplay" required class='form-control' value='{{ $row->total }}' readonly disabled/>
                <input type='hidden' id="total" required class='form-control' value='{{ $row->total }}' />
            </div>

            <div class='form-group'>
                <label>Status Terakhir</label>
                <input type='text' required class='form-control' value='{{$row->status}}' readonly disabled/>
            </div>

            <div class='form-group'>
                <label>Masukkan Alasan Penolakan <sup class='text-danger'><b>*</b></span></label>
                <textarea rows='5' maxlength="255" required class='form-control' name="notes" placeholder="Masukkan alasan penolakan terhadap permohonan"></textarea>
            </div>
        </div>
        
        <div class='panel-footer'>
            <input type='submit' class='btn btn-danger pull-right' value='Tolak'/>
            <a href="{{ CRUDBooster::mainPath() }}" class="btn btn-warning">Kembali</a>
        </div>
    </div>
</form>
@endsection

