const csrf = document.querySelector('[name="_token"]').value;
const selectMonth = document.querySelector('#month');
const selectYear = document.querySelector('#year');
const getDataBtn = document.querySelector('#getData');
const tbody = document.querySelector('#tbody');
const thisDate = new Date();
const thisMonth = thisDate.getMonth()+1;
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
    const links = document.querySelector('#links').value || 0;
    const referals = document.querySelector('#referals').value || 0;
    const pop_ads = document.querySelector('#pop_ads').value || 0;
    const other_ads = document.querySelector('#other_ads').value || 0;
    const dataToSend = thisMonth < 10 ? '0'+thisMonth : thisMonth;
    const params = {
        type: "post",
        links: links,
        referals: referals,
        pop_ads: pop_ads,
        other_ads: other_ads,
        info_date: dataToSend +'-'+thisYear,
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



                msgSweetAlert("success");

                const tr = document.createElement("tr");
/**
 * countItems gets of the view statistics and get the number of items in the table.
*/
                countItems++;
                const tdDay = document.createElement("td");
                tdDay.innerText = `${countItems}`;

                const tdLinks = document.createElement("td");
                tdLinks.innerText = `$${links}`;

                const tdReferals = document.createElement("td");
                tdReferals.innerText = `$${referals}`;

                const tdPop_ads = document.createElement("td");
                tdPop_ads.innerText = `$${pop_ads}`;

                const tdOhter_ads = document.createElement("td");
                tdOhter_ads.innerText = `$${other_ads}`;


                tr.append(tdDay);
                tr.append(tdLinks);
                tr.append(tdReferals);
                tr.append(tdPop_ads);
                tr.append(tdOhter_ads);
                tbody.prepend(tr);

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

saveData.addEventListener('click', add);
getDataBtn.addEventListener('click', index);
