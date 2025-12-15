$(document).on("click",".delete-data-info",function(){
    let dataID      = $(this).attr("data-id");
    let dataName    = $(this).attr("data-name");
    let dataUrl     = $(this).attr("data-url");
    let tableID     = $(this).closest(".table").attr("id");
    let table       = $(`#${tableID}`).DataTable(); 

    Swal.fire({
        title: `Are you sure you want to delete <span class='delete-name'>${dataName}</span> ?`,
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {

            $.ajax({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
                },
                type: "DELETE",
                url: `/${dataUrl}`,
                data: { id: dataID },
                success: function (data) {
                    table.row(`#tr${dataID}`).remove().draw(false);
                    Swal.fire({
                        icon: "success",
                        title: `${dataName} has been deleted.`,
                        showConfirmButton: false,
                        timer: 1500
                    }
                    ).then(function () {
                        location.reload();
                    });
                },
                error: function (error) {
                    console.log(error);
                },
            });
        }
    });



});