@extends('user.template')
@section('title','tableau bord admin')
@section('content')
<section style="padding-top: 60px;">
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header" style="color: black;">
                        Nombre de demandes
                    </div>
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-striped table-hover">
                            <thead>
                                <tr>
                                    <th scope="col">N° id</th>
                                    <th scope="col">Nom Admin</th>
                                    <th scope="col">Rejetée,</th>
                                    <th scope="col">En attente</th>
                                    <th scope="col"> Traitée</th>

                                </tr>
                            </thead>
                            <tbody>


                                <tr class="">
                                    <td scope="row">{{$id}}</td>
                                    <td>{{$nom}}</td>
                                    <td>{{$rejet}}</td>
                                    <td>
                                        {{$attente}}


                                    </td>
                                    <td>
                                        {{$traite}}


                                    </td>


                                </tr>

                            </tbody>
                        </table>

                </div>
            </div>
        </div>
    </div>
</section>





@endsection
