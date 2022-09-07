@Include('common.modalHead')

<div class="row">
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Fecha de Final</label>
            <input type="date" wire:model.lazy="fechaFin" class="form-control">
        </div>
        @error('fechaFin') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Descripcion</label>
            <input type="text" wire:model.lazy="descripcion" class="form-control">
        </div>
        @error('descripcion') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Nota</label>
            <textarea type="text" class="form-control" wire:model.lazy="nota"></textarea>
        </div>
        @error('nota') <span class="text-danger er">{{ $message }}</span> @enderror
    </div>
    <div class="col-sm-12 col-md-6">
        <div class="form-group">
            <label>Estado de Contrato</label>
            <label>Estado de Contrato</label>
            <select wire:model="estado" class="form-control">
                <option value="Elegir" disabled>Elegir</option>
                <option value="Activo" selected>Activo</option>
                <option value="Finalizado" selected>Finalizado</option>
            </select>
            @error('estado') <span class="text-danger er">{{ $message }}</span> @enderror
        </div>
        <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
            <label class="form-check-label" for="inlineRadio1">1</label>
          </div>
          <div class="form-check form-check-inline">
            <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
            <label class="form-check-label" for="inlineRadio2">2</label>
          </div>

          <label class="switch">
            <input data-id="#" class="mi_checkbox" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" >
            <span class="slider round"></span>
        </label>
    </div>
</div>

@include('common.modalFooter')