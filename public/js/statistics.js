const csrf = document.querySelector('[name="_token"]').value;
const selectMonth = document.querySelector('#month');
const selectYear = document.querySelector('#year');
const getDataBtn = document.querySelector('#getData');
const thisDate = new Date();
const thisMonth = thisDate.getMonth();
const thisYear = thisDate.getFullYear();

function index(){
    const params = {
        type: "get",
        month: selectMonth.value || thisMonth,
        year: selectYear.value || thisYear,
        _token: csrf,
    };
    console.log('params', params);
    $.ajax({
        url: "statistics/request",
        method: "POST",
        data: params,
        beforeSend: function () {},
        statusCode: {
            404: () => {
                msgSweetAlert("404");
            },
            500: () => {
                msgSweetAlert("500");
            },
        },
    })
        .done(function (response) {
            console.log('response', response);
            if (response.success) {
                const data = response.items;

                if (data.length == 0) {
                    console.log('No hay data');

                    /** we deleted all data of table and show msg with text there is no data */
                }else {
                    data.forEach(element => {
                        console.log(element);
                    });
                }

                /*

                vamos a estrar los datos del nuevo collection y los vamos a agregar o ya veremos algo que sea rapido 
                
                */


            } else {
                msgSweetAlert("error");
            }
        })
        .then(() => {});

}



function add() {
    const userName = document.querySelector("#name").value || "Empty";
    const description = document.querySelector("#description").value;
    const amount = document.querySelector("#amount").value;
    const params = {
        type: "post",
        name: userName,
        user: selectUser.value,
        description: description,
        // credit_type: credit_type.value,
        credit_type: 'from',
        date_info: date_info.value,
        time_type: time_type.value,
        amount: amount,
        // extends: extends_data.checked,
        extends: 0,
        _token: csrf,
    };

    $.ajax({
        url: "dashboard/request",
        method: "POST",
        data: params,
        beforeSend: function () {},
        statusCode: {
            404: () => {
                msgSweetAlert("404");
            },
            500: () => {
                msgSweetAlert("500");
            },
        },
    })
        .done(function (response) {
            console.log('response', response);
            if (response.success) {
                $("#newUserModal").modal("hide");
                msgSweetAlert("success");

                /*

                vamos a estrar los datos del nuevo collection y los vamos a agregar o ya veremos algo que sea rapido 
                
                */


            } else {
                msgSweetAlert("error");
            }
        })
        .then(() => {});
}
function msgSweetAlert(value) {
    switch (value) {
        case "500":
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Internal Server Error (500)",
            });
            break;
        case "404":
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Not Found (404)",
            });
            break;
        case "422":
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Unprocessable Content (422)",
            });
            break;
        case "success":
            Swal.fire("Good job!", "Success!", "success");
            break;
        case "deleted":
            Swal.fire("Deleted!", "Your file has been deleted.", "success");
            break;
        case "error":
            Swal.fire({
                icon: "error",
                title: "Oops...",
                text: "Something went wrong!",
            });
            break;
        default:
            break;
    }
}


function infoDates(){
    const month = ['january', 'february', 'march', 'april', 'may', 'june','july', 'august', 'september', 'october', 'november', 'december'];
    month.forEach(element =>{
        const option = document.createElement('option');
        let indexItem = month.indexOf(element)+1;
        option.value = indexItem < 10 ? `0${indexItem}` : indexItem;
        option.innerText = element[0].toUpperCase() + element.substring(1);
        selectMonth.appendChild(option);
    });
}
infoDates();


getDataBtn.addEventListener('click', index);
