<div>



    <div class="row">
        <div class="col-12 text-center">


            <button wire:click.prevent="crearpdf()">
                Crear Cotizacion
            </button>

            
        </div>
    </div>



    

</div>


@section('javascript')





<script>
    document.addEventListener('DOMContentLoaded', function() {
        //Crear pdf de Informe técnico de un servicio
        window.livewire.on('crear-cotizacion', Msg => {
            var win = window.open('crearcotizacion');
            // Cambiar el foco al nuevo tab (punto opcional)
            win.focus();
        });
    });
</script>

<!-- Scripts para el mensaje de confirmacion arriba a la derecha 'Mensaje Toast' de Éxito y Alerta de Eliminacion -->
<script src="{{ asset('plugins/sweetalerts/sweetalert2.min.js') }}"></script>
<script src="{{ asset('plugins/sweetalerts/custom-sweetalert.js') }}"></script>
<!-- Fin Scripts -->

@endsection