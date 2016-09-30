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
        <div class="col-md-4 col-sm-4 col-xs-12 form-group pull-left">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Selecciona fecha y franja</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div class="input-group">
                        <input type="text" class="form-control datepicker" v-model="date" >
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
        <div class="col-md-4 col-sm-4 col-xs-12 form-group pull-left">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Estado de las mesas</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <template v-for="table in tables">
                        <div class="col-md-6">
                            <button type="button" class="btn-lg btn-block btn" v-bind:class="{ 'btn-danger':  table.occupied, 'btn-success': !table.occupied}">{{table.name}}</button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
        <div class="col-md-4 col-sm-4 col-xs-12 form-group pull-left">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Reservas activas</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">

                </div>
            </div>
        </div>
    </div>
</div>

<template id="vue-toggle">
    <div class="btn-group">
        <button type="button"
                v-for="(key, val) in values"
                @click="changeSelectVal(key)"
                :class="['btn', { 'btn-danger': selected === key, 'btn-default': selected !== key }]"
        >{{ val }}</button>
    </div>
</template>
