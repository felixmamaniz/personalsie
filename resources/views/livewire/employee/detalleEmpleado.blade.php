<div wire:ignore.self class="modal fade" id="modal-details" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-body">

      <div class="row">
        <div class="col-md-3 pl-md-0 pr-md-0"></div>
        <div class="col-md-6 pl-md-0 pr-md-0">
          <div class="card-pricing2 card-primary">
            <div class="pricing-header">
              <h3 class="fw-bold">Informacion de Empleado</h3>
            </div>
            <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
            @foreach ($data as $d)
              <div class="price-value">
                <div class="value">
                  <img src="{{ asset('storage/employees/' .$d->image)}}"
                  alt="imagen de ejemplo" height="90" width="70" class="img-fluid rounded-start">
                </div>
              </div>
              <ul class="pricing-content">
                <li>NRO. DE CI: {{ $d->ci }}</li>
                <li>NOMBRE: {{ $d->name }}</li>
                <li>APELLIDO: {{ $d->lastname }}</li>
                <li>SEXO: {{ $d->genero }}</li>
                <li>FECHA DE NACIMIENTO: {{ $d->dateNac }}</li>
                <li>DIRECCION: {{ $d->address }}</li>
                <li>TELEFONO: {{ $d->phone }}</li>
                <li>ESTADO CIVIL: {{ $d->estadoCivil }}</li>
                <li>AREA DE TRABAJO: {{ $d->area }}</li>
                <li>PUESTO DE TRABAJO: {{ $d->puesto }}</li>
                <li>ESTADO DE CONTRATO: {{$estadocontrato}}</li>
              </ul>
            @endforeach
            <a wire:click.prevent="resetUI()" data-dismiss="modal" class="btn btn-primary btn-border btn-lg w-75 fw-bold mb-3">Cerrar</a>
          </div>
        </div>
      </div>
      
    </div>
  </div>
</div>