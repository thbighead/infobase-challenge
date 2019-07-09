function _() {
    var dTable = this;
    dTable.api().columns().every(function () {
        var column = this;
        var string = $(column.footer()).html();
        if (string.length > 0) {
            var title, name;
            if (~string.indexOf(',')) {
                title = string.split(',')[1];
                name = string.split(',')[0];
            } else {
                title = name = string;
            }
            var input = '<input name="' + name + '" style="width: 100%; min-width: 57px;" type="text" placeholder="Buscar ' + title + '" />';
            $(input).appendTo($(column.footer()).empty()).on('change', function () {
                column.search($(this).val()).draw()
            })
        }
    });

    $('#search-form').on('submit', function (e) {
        e.preventDefault();
        // console.log($(this).serialize());
        // console.log(JSON.stringify($(this).serialize()));
        // console.log($(this).serializeArray());
        // console.log(JSON.stringify($(this).serializeArray()));
        dTable.api().search($(this).serialize()).draw();
    })
}