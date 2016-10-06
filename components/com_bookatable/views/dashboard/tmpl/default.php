<?php defined('_JEXEC') or die('Restricted access'); ?>
<div id="dashboard">
    <div class="row">
        <div class="col-md-5 col-sm-5 col-xs-12">
            <h1>Reservas de mesas</h1>
        </div>

        <div class="title_right">

        </div>
    </div>
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Selecciona fecha y franja</h2><br><br>
                    <small>Primero selecciona el dia y la franja horaria que te interesan</small>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker" v-model="date"
                               v-on:change="date && getTables()">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
                    </span>
                    </div>
                    <fieldset class="form-group">
                        <legend class="sr-only">Franja</legend>
                        <div class="form-group">
                            <vue-toggle :values="franjas" :selected.sync="franja" default="2"></vue-toggle>
                        </div>
                    </fieldset>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 form-group">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Estado de las mesas</h2><br><br>
                    <small>Selecciona una de las mesas verdes para hacer una reserva</small>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <template v-for="table in tables">
                        <div class="col-md-6">
                            <button type="button" class="btn-lg btn-block btn" data-toggle="modal"
                                    data-target="#myModal{{table.id}}"
                                    v-bind:class="{ 'btn-danger':  table.occupied, 'btn-success': !table.occupied}">
                                {{table.name}}
                            </button>
                            <!-- Modal mesa libre -->
                            <div v-if="!table.occupied" class="modal fade" id="myModal{{table.id}}" tabindex="-1"
                                 role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Reservar {{table.name}}</h4>
                                        </div>
                                        <div class="modal-body">
                                            ¿Estas seguro que quieres reservar la {{table.name}} para el {{date_formated}} por la {{franja.replace("1", "Mañana").replace("2", "Tarde").replace("3", "Noche")}}?
                                            <br>
                                            Si es así indica a que juego vas a jugar, por favor.
                                            <select v-model="selected_game">
                                                <option value="0">Selecciona un sistema de juego</option>

                                                <template v-for="game in games">
                                                    <option value="{{game.id}}">{{game.name}}</option>
                                                </template>
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <button type="button" class="btn btn-primary"  @click="selected_game == 0 ? alert('Debes seleccionar un sistema de juego') : setBooking(table.id)" >Reservar
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Mesa ocupada -->
                            <div v-if="table.occupied" class="modal fade" id="myModal{{table.id}}" tabindex="-1"
                                 role="dialog" aria-labelledby="myModalLabel">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span></button>
                                            <h4 class="modal-title" id="myModalLabel">Mesa ocupada</h4>
                                        </div>
                                        <div class="modal-body">
                                            Esta mesa esta ocupada
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-default" data-dismiss="modal">
                                                Cancelar
                                            </button>
                                            <button type="button" class="btn btn-primary" disabled>Reservar</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </template>
                </div>
            </div>
        </div>
        <template v-if="bookings">
            <div class="col-md-4 col-sm-4 col-xs-12 form-group">
                <div class="x_panel">
                    <div class="x_title">
                        <h2>Reservas activas</h2><br><br>
                        <small>Haz click en el <i class="fa fa-trash"></i> para eliminar la reserva</small>
                        <div class="clearfix"></div>
                    </div>
                    <div class="x_content">
                        <table class="table">
                            <tr>
                                <th>Mesa</th>
                                <th>Fecha</th>
                                <th>Franja</th>
                                <th></th>
                            </tr>
                            <tr v-for="booking in bookings">
                                <td>{{booking.table_name}}</td>
                                <td>{{booking.date}}</td>
                                <td>{{booking.evening}}</td>
                                <td><i class="fa fa-trash" @click="deleteBooking(booking.id)" ></i></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>

<template id="vue-toggle">
    <div class="btn-group">
        <button type="button"
                v-for="(key, val) in values"
                @click="changeSelectVal(key)"
                :class="['btn', { 'btn-danger': selected === key, 'btn-default': selected !== key }]"
        >{{ val }}
        </button>
    </div>
</template>
