Vue.component('greeting', {
    template: '<h1>Welcome to coligo!</h1>'
});

var Toggle = Vue.extend({
    template: '#vue-toggle',
    props: ['values','selected','default'],
    ready: function () {
        this.selected = this.default;
    },
    methods: {
        changeSelectVal: function(val) {
            this.selected = val;
            vm.getTables();
        }
    }
});
Vue.component('vue-toggle', Toggle);

// create a new Vue instance and mount it to our div element above with the id of app
var vm = new Vue({
    el: '#dashboard',
    data:{
        date: moment().format('YYYY-MM-DD'),
        date_formated: moment().locale('es').format('LL'),
        franja: '2',
        selected_game: '0',
        franjas: {
            '1': 'Mañana',
            '2': 'Tarde',
            '3': 'Noche'
        },
        tables:{

        },
        bookings:{

        },
        games:{

        },

    },
    watch: {
        date: function(val, oldVal){
            vm.date_formated = moment(val).locale('es').format('LL'),
            vm.getTables();
        }
    },
    methods: {
        alert: function(msg) {
            alert(msg);
        },
        getBookings: function() {

            this.$http.get('/index.php?option=com_bookatable&task=dashboard.getBookings').then((response) => {

                // success callback
                if (response.body == "null")
                {
                    vm.bookings = null;
                }else{
                    vm.bookings = JSON.parse(response.body).bookings.filter(function (item) {
                        item.evening = item.evening.replace("1", "Mañana");
                        item.evening = item.evening.replace("2", "Tarde");
                        item.evening = item.evening.replace("3", "Noche");
                        return item.evening;
                    });
                }

            }, (response) => {
                // error callback
                alert('Ha ocurrido un error vuelve a cargar la página e intentalo otra vez.');
            });
        },
        getTables: function() {

            var formData = new FormData();

            formData.append('date', vm.date);
            formData.append('franja', vm.franja);

            this.$http.post('/index.php?option=com_bookatable&task=dashboard.getTables', formData).then((response) => {
                vm.tables = JSON.parse(response.body).tables;
            }, (response) => {
                // error callback
                alert('Ha ocurrido un error vuelve a cargar la página e intentalo otra vez.');
            });
        },
        getGames: function() {

            this.$http.get('/index.php?option=com_bookatable&task=dashboard.getGames').then((response) => {
                vm.games = JSON.parse(response.body).games;
            }, (response) => {
                // error callback
                alert('Ha ocurrido un error vuelve a cargar la página e intentalo otra vez.');
            });
        },
        setBooking: function(table_id) {
            var formData = new FormData();

            formData.append('table_id', table_id);
            formData.append('date', vm.date);
            formData.append('franja', vm.franja);
            formData.append('selected_game', vm.selected_game);


            this.$http.post('/index.php?option=com_bookatable&task=dashboard.setBooking', formData).then((response) => {
                vm.getTables();
                vm.getBookings();
                alert(JSON.parse(response.body).msg);

                $('#modal'+table_id).modal('hide');
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
        }, (response) => {
                // error callback
                alert('Ha ocurrido un error vuelve a cargar la página e intentalo otra vez.');
            });
        },
        deleteBooking: function(booking_id) {

            var formData = new FormData();

            formData.append('id', booking_id);

            this.$http.post('/index.php?option=com_bookatable&task=dashboard.deleteBooking', formData).then((response) => {
                vm.getTables();
                vm.getBookings();
                alert(JSON.parse(response.body).msg);
        }, (response) => {
                // error callback
                alert('Ha ocurrido un error vuelve a cargar la página e intentalo otra vez.');
            });
        },
    }
});

vm.getTables();
vm.getBookings();
vm.getGames();
