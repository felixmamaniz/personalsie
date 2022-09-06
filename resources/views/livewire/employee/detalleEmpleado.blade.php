<div wire:ignore.self class="modal fade" id="modal-details" tabindex="-1" role="dialog">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header" style="background: #414141">
        <h5 class="modal-title text-white">
          <b>Detalle de Empleado</b>
        </h5>
        <h6 class="text-center text-warning" wire:loading>POR FAVOR ESPERE</h6>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-3 pl-md-0 pr-md-0">
          
          </div>
          <div class="col-md-6 pl-md-0 pr-md-0">
            <div class="card-pricing2 card-primary">
              <div class="pricing-header">
                <h3 class="fw-bold">Business</h3>
                <span class="sub-title">Lorem ipsum</span>
              </div>
              <div class="price-value">
                <div class="value">
                  <span class="currency">$</span>
                  <span class="amount">20.<span>99</span></span>
                  <span class="month">/month</span>
                </div>
              </div>
              <ul class="pricing-content">
                <li>60GB Disk Space</li>
                <li>60 Email Accounts</li>
                <li>60GB Monthly Bandwidth</li>
                <li>15 Subdomains</li>
                <li class="disable">20 Domains</li>
              </ul>
              <a href="#" class="btn btn-primary btn-border btn-lg w-75 fw-bold mb-3">Sign up</a>
            </div>
          </div>
          <div class="col-md-3 pl-md-0 pr-md-0">
  
          </div>
        </div>
        
        <div class="table-responsive">

          <div class="card mb-3" style="max-width: 752px;">
            <div class="row g-0" style="background: #e6e6e9">
              @foreach ($data as $d)
              <div class="col-md-4">
                <img src="{{ asset('storage/employees/' .$d->image)}}"
                  alt="imagen de ejemplo"  class="img-fluid rounded-start">
              </div>
              <div class="col-sm-6 mt-3" style="background: #e6e6e9">
                <div class="card-body">
                  <h5 class="card-title">Datos del Empleado</h5>
                    <h6>NRO. DE CI: {{ $d->ci }}</h6>
                    <h6>NOMBRE: {{ $d->name }}</h6>
                    <h6>APELLIDO: {{ $d->lastname }}</h6>
                    <h6>SEXO: {{ $d->genero }}</h6>
                    <h6>FECHA DE NACIMIENTO: {{ $d->dateNac }}</h6>
                    <h6>DIRECCION: {{ $d->address }}</h6>
                    <h6>TELEFONO: {{ $d->phone }}</h6>
                    <h6>ESTADO CIVIL: {{ $d->estadoCivil }}</h6>
                    <h6>AREA DE TRABAJO: {{ $d->area }}</h6>
                    <h6>PUESTO DE TRABAJO: {{ $d->puesto_trabajo_id }}</h6>
                    <h6>ESTADO DE CONTRATO: {{$d->estado}}</h6>
                </div>
              </div>
              @endforeach
            </div>
          </div>
          
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" wire:click.prevent="resetUI()" class="btn btn-dark close-btn text-info"
          data-dismiss="modal" style="background: #3b3f5c">CERRAR
        </button>
      </div>
    </div>
  </div>
</div>