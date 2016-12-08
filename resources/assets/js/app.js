
/**
 * First we will load all of this project's JavaScript dependencies which
 * include Vue and Vue Resource. This gives a great starting point for
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data: {
        process: false,
        processes: []
    },
    methods: {
        processAction(processName, action) {
            let self = this;

            $.ajax({
                url: '/api/supervisord/process?api_token=password',
                method: 'POST',
                data: {
                    processName: processName,
                    action: action
                },
                success: function (result) {
                    if (result.success) {
                        self.loadProcesses();
                    }
                }
            });
        },
        viewProcess(process) {
            let self = this;

            self.process = process;

            self.tailLog();
        },
        hideProcess() {
            this.process = false;
        },
        tailLog() {
            let self = this;

            if (typeof self.process.name !== 'undefined') {
                $.ajax({
                    url: '/api/supervisord/process/tail/' + self.process.name + '?api_token=password',
                    method: 'GET',
                    success: function (result) {
                        if (result.success) {
                            $('.process-log-preview pre').append(result.data);
                        }

                        setTimeout(function () {
                            self.tailLog();
                        }, 500);
                    }
                });
            }
        },
        loadProcesses() {
            let self = this;

            $.ajax({
                url: '/api/supervisord/process?api_token=password',
                method: 'GET',
                success: function (result) {
                    if (result.success) {
                        self.processes = result.data;
                    }
                }
            });
        }
    },
    mounted() {
        this.loadProcesses();
    }
});
