(function ($, DataTable) {
    "use strict";

    var _buildUrl = function (dt, action) {
        var url = dt.ajax.url() || '';
        var params = dt.ajax.params();
        params.action = action;

        if (url.indexOf('?') > -1) {
            return url + '&' + $.param(params);
        }

        return url + '?' + $.param(params);
    };

    DataTable.ext.buttons.excel = {
        className: 'buttons-excel',

        text: function (dt) {
            return '<i class="fa fa-file-excel-o"></i> ' + dt.i18n('buttons.excel', 'Excel');
        },

        action: function (e, dt, button, config) {
            var url = _buildUrl(dt, 'excel');
            window.location = url;
        }
    };

    DataTable.ext.buttons.export = {
        extend: 'collection',

        className: 'buttons-export',

        text: function (dt) {
            return '<i class="fa fa-download"></i> ' + dt.i18n('buttons.export', 'Exportar') + '&nbsp;<span class="caret"/>';
        },

        buttons: ['csv', 'excel', 'pdf']
    };

    DataTable.ext.buttons.csv = {
        className: 'buttons-csv',

        text: function (dt) {
            return '<i class="fa fa-file-excel-o"></i> ' + dt.i18n('buttons.csv', 'CSV');
        },

        action: function (e, dt, button, config) {
            var url = _buildUrl(dt, 'csv');
            window.location = url;
        }
    };

    DataTable.ext.buttons.pdf = {
        className: 'buttons-pdf',

        text: function (dt) {
            return '<i class="fa fa-file-pdf-o"></i> ' + dt.i18n('buttons.pdf', 'PDF');
        },

        action: function (e, dt, button, config) {
            var url = _buildUrl(dt, 'pdf');
            window.location = url;
        }
    };

    DataTable.ext.buttons.print = {
        className: 'buttons-print',

        text: function (dt) {
            return '<i class="fa fa-print"></i> ' + dt.i18n('buttons.print', 'Imprimir');
        },

        action: function (e, dt, button, config) {
            var url = _buildUrl(dt, 'print');
            window.location = url;
        }
    };

    DataTable.ext.buttons.reset = {
        className: 'buttons-reset',

        text: function (dt) {
            return '<i class="fa fa-undo"></i> ' + dt.i18n('buttons.reset', 'Reset');
        },

        action: function (e, dt, button, config) {
            dt.search('').draw();
        }
    };

    DataTable.ext.buttons.reload = {
        className: 'buttons-reload',

        text: function (dt) {
            return '<i class="fa fa-refresh"></i> ' + dt.i18n('buttons.reload', 'Reload');
        },

        action: function (e, dt, button, config) {
            dt.draw(false);
        }
    };

    DataTable.ext.buttons.create = {
        className: 'buttons-create',

        text: function (dt) {
            return '<i class="fa fa-plus"></i> ' + dt.i18n('buttons.create', 'Cadastrar');
        },

        action: function (e, dt, button, config) {
            window.location = window.location.href.replace(/\/index?\/+\d*$/, "") + '/create';
        }
    };

    DataTable.ext.buttons.csvExport = {
        className: 'buttons-csvExport',

        text: function (dt) {
            return '<i class="fa fa-file-excel-o"></i> ' + dt.i18n('buttons.csvExport', 'CSV');
        },

        action: function (e, dt, button, config) {
            let country_id = window.location.href.split('/')[5];
            let sgo = window.location.href.replace(/\/+$/, "")
                + '?action=csvExport&country_id=' + country_id
                + '&filter_mode=' + $('input[name="filter_mode"]').val();
            $.each($('#search-form select[name="areas[]"]').val(), function (index, value) {
                if (value.length > 0)
                    sgo += '&areas[]=' + value;
            });
            $.each($('#search-form select[name="tags[]"]').val(), function (index, value) {
                if (value.length > 0)
                    sgo += '&tags[]=' + value;
            });
            $('#laravel-datatable tfoot th input').each(function () {
                let value = $(this).val();
                if (value.length > 0)
                    sgo += '&' + $(this).attr('name') + '=' + value;
            });
            // console.log(sgo);
            window.location = sgo;
        }
    };
})(jQuery, jQuery.fn.dataTable);
