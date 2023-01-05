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
        // statusCode: {
        //     404: () => { msgSweetAlert('404') },
        //     500: () => { msgSweetAlert('500') }           
        // },
    }).done(function(response){
        console.log('response', response);
    }).then(()=>{
    });











    console.log('Hi!');


}


addBtn.addEventListener('click', add);
