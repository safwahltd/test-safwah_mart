

function delete_item(url, message = null)
{
    Swal.fire({
        title: 'Are you sure ?',
        html:   `<div style='margin: 10px 0'>
                    ${message != null ? '<b style="font-size: 16px">'+ message +'</b>' : '<b>You will delete this record permanently !</b>'}
                </div>`,
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        width:400,
    }).then((result) =>{
        if(result.value){
            // $('deleteItemForm').attr({'action': url});
            $('#deleteItemForm').attr('action', url).submit();
        }
    })

}
