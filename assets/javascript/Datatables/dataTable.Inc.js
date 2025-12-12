$(document).ready(function() {
    $(document).ready(function() {
        var table = $('#example').DataTable({
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });

        // Order by the grouping
        $('#example tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
    });
});
$('#example23').DataTable({
    dom: 'Bfrtip',
    buttons: [
        'csv'
    ]
});
$('#myTable').DataTable({
	"order":[[0,1,"desc"]],
    searching: false
});
$('#ticketDetailClient').DataTable({
    "order":[[0,"asc"]],
    searching: false
});
$('#sotirBanqueTb').DataTable({
    "order":[[0,1,"desc"]]
});

// Fiche Intervention table

$('#listeFichIntervention').DataTable({
    "order":[[0,1,"desc"]],
    searching: false
});

$('#customer_note_table').DataTable({
    "order":[[0,1,"desc"]],
    searching: false
});