$(function () {
    $("#defaultTable").DataTable({
        "responsive": true,
        "lengthChange": false,
        "autoWidth": false,
        "buttons": ["csv", "pdf", "print"]
    }).buttons().container().appendTo('#defaultTable_wrapper .col-md-6:eq(0)');

    
});


