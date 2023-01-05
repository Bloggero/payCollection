const csrf = document.querySelector('[name="_token"]').value;

function add(){
    const params = {'type' : 'post', 'name' : document.querySelector('#name').value, 'description' : description.value, 'credit_type' : credit_type.value, 'date_info' : date_info.value, 'time_type' : time_type.value, 'amount' : amount.value, 'extends' : extends_data.checked, '_token' : csrf};
    console.log('csrf', csrf);
console.log('params', params);

$.ajax({
        url: 'dashboard/request',
        method: 'POST',
        data: params,
        beforeSend: function () {
        
        },
        statusCode: {
            404: () => { msgSweetAlert('404') },
            500: () => { msgSweetAlert('500') }           
        },
    }).done(function(response){
        if(response.success){
            $("#newUserModal").modal('hide');
            msgSweetAlert('success');
        }else{
            msgSweetAlert('error');
        }
    }).then(()=>{
    });

}
function msgSweetAlert(value){
    switch (value) {
        case '500':
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Internal Server Error (500)',
            })
        break;
        case '404':
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Not Found (404)',
            })
        break;
        case '422':
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Unprocessable Content (422)',
            })
        break;
        case 'success':
            Swal.fire(
                'Good job!',
                'Success!',
                'success'
            )
        break;
        case 'deleted':
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
              )
        break;
        case 'error':
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            })
        break;
        default:
            break;
    }
}

addBtn.addEventListener('click', add);
