const csrf = document.querySelector('[name="_token"]').value;

function add(){
    const userName = document.querySelector('#name').value || "Empty";
    const description = document.querySelector('#description').value;
    const amount = document.querySelector('#amount').value;
    const params = {'type' : 'post', 'name' : userName, 'user' : selectUser.value, 'description' : description, 'credit_type' : credit_type.value, 'date_info' : date_info.value, 'time_type' : time_type.value, 'amount' : amount, 'extends' : extends_data.checked, '_token' : csrf};

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

            const container = document.createElement('div');
                container.classList.add("col-12", "col-sm-12", "col-md-4", "col-lg-3");
            const card = document.createElement("div");
                card.classList.add("card");
            const cardHeader = document.createElement("div");
                cardHeader.classList.add("card-header");
            const bUsername = document.createElement("b");
                bUsername.innerText = userName;

                if(selectUser.value != 'nothing'){
                    bUsername.innerText = selectUser.options[selectUser.selectedIndex].getAttribute("forName");
                }else{
                    const selectOption = document.createElement("option");
                        selectOption.value = response.user_id;
                        selectOption.setAttribute("forName", `${response.name}`);
                        selectOption.innerText = `${response.name} / ${response.email}`;
                        selectUser.appendChild(selectOption);
                }

            const labelShowModal = document.createElement("label");
                labelShowModal.classList.add("float-right");
                labelShowModal.setAttribute("data-toggle", "modal");
                labelShowModal.setAttribute("data-target", "#showCardModal");
            const iconLabel = document.createElement("i");
                iconLabel.classList.add("fa", "fa-eye");
                iconLabel.setAttribute("aria-hidden", "true");
            const cardBody = document.createElement("div");
                cardBody.classList.add("card-body");
            const divDescription = document.createElement("p");
                divDescription.classList.add("card-text", "text-muted");
                divDescription.innerText = description;
            const hr = document.createElement("hr");
            const divAmount = document.createElement("p");
                divAmount.classList.add("card-text", "text-danger");
            const bAmount = document.createElement("b");
                bAmount.innerText = `$${amount}`;
            const pay = document.createElement("a");
                pay.classList.add("card-link", "bg-success");
                pay.setAttribute("href", "#");
            const cardFooter = document.createElement("div");
                cardFooter.classList.add("card-footer", "text-center");
                cardFooter.innerText = "Pay";

            container.appendChild(card);
                card.appendChild(cardHeader);
                    cardHeader.appendChild(bUsername);
                    cardHeader.appendChild(labelShowModal);
                        labelShowModal.appendChild(iconLabel);
                card.appendChild(cardBody);
                    cardBody.appendChild(divDescription);
                    cardBody.appendChild(hr);
                    cardBody.appendChild(divAmount);
                        divAmount.appendChild(bAmount);
                card.appendChild(pay);
                    pay.appendChild(cardFooter);
                
            divBtnNewUser.after(container);

            document.querySelector('#name').value = '';
            document.querySelector('#description').value = '';
            credit_type.value = 'from';
            date_info.value = new Date();
            time_type.value = 'week';
            document.querySelector('#amount').value = '';
            extends_data.checked = false;



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



const dashboardItems = document.querySelectorAll('.showUser');

function show(value) {
    const user_id = value.target.getAttribute("user");
    const params = {'type' : 'get', 'user_id' : user_id, '_token' : csrf};

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
        console.log('response', response);
        if(response.success){
            // $("#newUserModal").modal('hide');
            // msgSweetAlert('success');

        

        }else{
            msgSweetAlert('error');
        }
    }).then(()=>{
    });

}

dashboardItems.forEach(box => box.addEventListener('click', show));


addBtn.addEventListener('click', add);
