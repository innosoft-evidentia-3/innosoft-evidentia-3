@if ($evidence->status != 'ACCEPTED')
<a class="btn btn-success btn-sm" href="{{route('coordinator.evidence.accept',['instance' => $instance, 'id' => $evidence->id])}}">
    <i class="far fa-thumbs-up"></i>
    Aceptar
</a>
@endif

@if ($evidence->status != 'REJECTED')
<a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-rejected-{{$evidence->id}}">
    <i class="far fa-thumbs-down"></i>
    Rechazar
</a>
@endif

<div class="container">
    <div class="modal fade" id="modal-rejected-{{$evidence->id}}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content" style="overflow: visible">
                <div class="modal-header">
                    <h4 class="modal-title text-wrap">Rechazar evidencia</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form action="{{route('coordinator.evidence.reject',['instance' => $instance])}}" method="POST">
                    @csrf
                    <input type="hidden" name="_id" value="{{$evidence->id}}"/>
                    <div class="modal-body text-wrap">
                        <x-textareasimple col="12" attr="reasonrejection"
                                    label="Motivo de rechazo"
                                    description="Escribe un motivo de por qué se rechaza esta evidencia (entre 10 y 1000 caracteres)."
                        />
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-danger">
                            <i class="far fa-thumbs-down"></i> &nbsp;Rechazar evidencia
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

</div>
