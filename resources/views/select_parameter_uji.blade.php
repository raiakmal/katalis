@php

$data = collect([]);

if($row) {
    $data = json_decode($row->testings);
}   
@endphp

<style>
.parameterChooserWrapper, #emptyWrapper {
    width: 100%;
    height: fit-content;
    border: 2px dotted #52b4eb;
    padding: 10px;
    display: flex;
    background: #d8f1ff;
    border-radius: 15px;
    gap: 10px;
    justify-content: center;
}

.totalWrapper {
    margin-top: 20px;
    width: fit-content;
    height: fit-content;
    border: 2px dotted #52b4eb;
    padding: 10px 15px;
    display: flex;
    gap: 10px;
    background: #d8f1ff;
    font-weight: 600;
    font-size: 20px;
    border-radius: 15px;
    float: right;
}

.parameterChild {
    display: flex;
    flex-basis: 33.333333%;
    flex-grow: 1;
    padding: 10px;
    border: 1px solid #52b4eb;
    border-radius: 15px;
    background: #fff;
    cursor: pointer;
    flex-direction: row;
}

.parameterChild > input[type=checkbox] {
    margin: 0 5px 0 0;
}

.flex-column {
    flex-direction: column;
}

.flex-row {
    flex-direction: row;
}

.d-flex {
    display: flex;
}

#emptyWrapper {
    font-size: 18px;
    color: red;
    font-weight: 600;
    text-style: italic;
    margin: auto;
}
</style>

<div class="parameterChooserWrapper" style="display: none">
    @foreach ($allParameters as $item)
        <div class="parameterChild" data-group="{{ $item->type }}">
            <div class="d-flex flex-row" style="gap: 10px">
                <input type="checkbox" class="inputParams" name="testings[]" value="{{ $item->id }}" data-price="{{ $item->price }}" {{ $item->status == "Active" ? '' : 'disabled' }}>
                <div class="d-flex flex-column">
                    <div class="d-flex">
                        {{ $item->parameter }} @if($item->noik) ({{ $item->noik }}) @endif
                    </div>
                    <div class="d-flex">
                        Rp{{ number_format($item->price, 0, ".", ",") }}
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>

<div id="emptyWrapper">
    Mohon Pilih Jenis Pengujian Terlebih Dahulu
</div>

<div class="totalWrapper">
    Rp<span id="totalText">0</span>
    <input type="hidden" name="total" value="0">
</div>