@extends('layouts.app')

@section('title', 'Mis convocatorias')

@section('title-icon', 'fas fa-list')

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="/{{$instance}}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{route('secretary.meeting.manage',\Instantiation::instance())}}">Gestionar reuniones</a></li>
    <li class="breadcrumb-item active">@yield('title')</li>
@endsection

@section('content')

    <div class="row">

        <x-menumeeting/>

        <div class="col-lg-9">
            <div class="row mb-3">
                <p style="padding: 5px 50px 0px 315px">Exportar tabla:</p>
                <div class="col-lg-1 mt-12">
                    <a href="{{route('secretary.meeting.manage.request.export',['instance' => $instance, 'ext' => 'xlsx'])}}"
                       class="btn btn-info btn-block" role="button">
                        XLSX</a>
                </div>
                <div class="col-lg-1 mt-12">
                    <a href="{{route('secretary.meeting.manage.request.export',['instance' => $instance, 'ext' => 'csv'])}}"
                       class="btn btn-info btn-block" role="button">
                        CSV</a>
                </div>
                <div class="col-lg-1 mt-12">
                    <a href="{{route('secretary.meeting.manage.request.export',['instance' => $instance, 'ext' => 'pdf'])}}"
                       class="btn btn-info btn-block" role="button">
                        PDF</a>
                </div>
            </div>

            <div class="card shadow-sm">

                <div class="card-body">

                    <table id="dataset" class="table table-hover table-responsive">
                        <thead>

                        <tr>
                            <th scope="col">Título</th>
                            <th scope="col">Última modificación</th>
                            <th scope="col">Programada para</th>
                            <th scope="col">PDF</th>
                        </tr>
                        </thead>

                        <tbody>
                        @foreach($meeting_requests as $meeting_request)
                            <tr scope="row">
                                <td>
                                    {{$meeting_request->title}}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($meeting_request->updated_at)->diffForHumans() }}
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($meeting_request->datetime)->format('d/m/Y') }}
                                    a las
                                    {{ \Carbon\Carbon::parse($meeting_request->datetime)->format('H:i') }}
                                    ({{ \Carbon\Carbon::parse($meeting_request->datetime)->diffForHumans() }})
                                </td>

                                <td>
                                    <a class="btn btn-primary btn-sm" href="{{route('secretary.meeting.manage.request.download',['instance' => $instance, 'id' => $meeting_request->id])}}"><i class="fas fa-file-pdf"></i></a>

                                    <a class="btn btn-info btn-sm" href="{{route('secretary.meeting.manage.request.edit',['instance' => $instance, 'id' => $meeting_request->id])}}"><i class="fas fa-edit"></i></a>

                                    <a class="btn btn-danger btn-sm" href="#" data-toggle="modal" data-target="#modal-confirm-REMOVE-{{$meeting_request->id}}">
                                        <i class="fas fa-trash"></i>
                                    </a>

                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                </div>

            </div>


        </div>
    </div>

    @foreach($meeting_requests as $meeting_request)
        <div class="modal fade" id="modal-confirm-REMOVE-{{$meeting_request->id}}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="overflow: visible">
                    <div class="modal-header">
                        <h4 class="modal-title text-wrap">¿Seguro?</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body text-wrap">
                        <p>Si hay alguna hoja de firmas asociada, no se verá afectada, solo se desparejará.</p>
                        <p>Ningún acta se verá afectada.</p>
                        <p>¿Deseas continuar?</p>
                    </div>
                    <div class="modal-footer justify-content-between">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>

                        <form id="buttonconfirm-form-{{$meeting_request->id}}" action="{{route('secretary.meeting.manage.request.remove',$instance)}}" method="post">
                            @csrf

                            <input type="hidden" name="meeting_request_id" value="{{$meeting_request->id}}"/>

                        </form>

                        <button type="buton" onclick="event.preventDefault(); document.getElementById('buttonconfirm-form-{{$meeting_request->id}}').submit();" class="btn btn-danger" data-dismiss="modal">
                            <i class="fas fa-trash"></i> &nbsp;Sí, eliminar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach


@endsection
