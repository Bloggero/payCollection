const csrf = document.querySelector('[name="_token"]').value;
const selectMonth = document.querySelector('#month');
const selectYear = document.querySelector('#year');
const getDataBtn = document.querySelector('#getData');
const spanSpin = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Loading...`;

const revenue = document.querySelector('#revenue');
const expenses = document.querySelector('#expenses');
const lastRevenue = document.querySelector('#lastRevenue');
const lastExpenses = document.querySelector('#lastExpenses');

const tbody = document.querySelector('#tbody');
const thisDate = new Date();
const thisMonth = thisDate.getMonth() + 1;
const thisYear = thisDate.getFullYear();
const alertToRecharge = document.querySelector('#alertToRecharge');
let searchData = false;

function index() {

    const params = {
        type: "get",
        month: selectMonth.value || thisMonth,
        year: selectYear.value || thisYear,
        _token: csrf,
    };
    $.ajax({
            url: "statistics/request",
            method: "POST",
            data: params,
            beforeSend: function () {
                getDataBtn.innerHTML    = spanSpin;
                revenue.innerHTML       = spanSpin;
                expenses.innerHTML      = spanSpin;
                lastRevenue.innerHTML   = spanSpin;
                lastExpenses.innerHTML  = spanSpin;
                earnings.innerHTML      = spanSpin;
                lastEarnings.innerHTML  = spanSpin;
                tbody.innerHTML         = spanSpin;
            },
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

            searchData = true;
            if (response.success) {
                tbody.innerHTML = ``;
                const data = response.items;

                if (data.length == 0) {

                    changeDataCard(0, 0, 0, 0);

                    const tr = document.createElement("tr");
                    const td = document.createElement("td");
                    td.innerText = `No data for this search`;
                    tr.append(td);
                    tbody.append(tr);

                } else {

                    data.reverse();
                    data.forEach((element, index) => {
                        appendTableStructure(index + 1, element.links || 0, element.referals || 0, element.pop_ads || 0, element.other_ads || 0);
                    });

                    const thisRevenue = data.reduce((acc, item) => acc + item.pop_ads, 0) + data.reduce((acc, item) => acc + item.other_ads, 0);
                    const thisExpenses = data.reduce((acc, item) => acc + item.links, 0) + data.reduce((acc, item) => acc + item.referals, 0);
                    console.log('thisRevenue', thisRevenue);
                    changeDataCard(thisRevenue || 0, thisExpenses || 0, response.lastItems.lastRevenue || 0, response.lastItems.lastExpenses || 0);
                    
                }
            } else {
                msgSweetAlert("error");
            }
        })
        .then(() => {
            getDataBtn.innerHTML = `Get Data`;
        });
}

function add() {
    const links = document.querySelector('#links');
    const referals = document.querySelector('#referals');
    const pop_ads = document.querySelector('#pop_ads');
    const other_ads = document.querySelector('#other_ads');
    const dataToSend = thisMonth < 10 ? '0' + thisMonth : thisMonth;
    const params = {
        type: "post",
        links: links.value || 0,
        referals: referals.value || 0,
        pop_ads: pop_ads.value || 0,
        other_ads: other_ads.value || 0,
        info_date: dataToSend + '-' + thisYear,
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
                /**
                 * countItems gets of the view statistics and get the number of items in the table.
                 */
                if (!searchData) {
                    countItems++;
                    appendTableStructure(countItems, links.value || 0, referals.value || 0, pop_ads.value || 0, other_ads.value || 0);
                }else{
                    alertToRecharge.style.display = 'block';
                }

                links.value = '';
                referals.value = '';
                pop_ads.value = '';
                other_ads.value = '';

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

function appendTableStructure(countItems, links, referals, pop_ads, other_ads) {

    const tr = document.createElement("tr");

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


}

function changeDataCard(valRevenue, valExpenses, valLastRevenue, valLastExpenses){
    console.log('valLastRevenue', valLastRevenue);
    console.log('valLastExpenses', valLastExpenses);
    revenue.innerText       = valRevenue.toFixed(2);
    expenses.innerText      = valExpenses.toFixed(2);
    lastRevenue.innerText   = valLastRevenue.toFixed(2);
    lastExpenses.innerText  = valLastExpenses.toFixed(2);
    earnings.innerHTML      = (valRevenue-valExpenses).toFixed(2);
    lastEarnings.innerHTML  = (valLastRevenue-valLastExpenses).toFixed(2);

}

function infoDates() {
    /**
     * This is only for fill selects for dates
     */
    const month = ['january', 'february', 'march', 'april', 'may', 'june', 'july', 'august', 'september', 'october', 'november', 'december'];
    month.forEach(element => {
        const option = document.createElement('option');
        let indexItem = month.indexOf(element) + 1;
        option.value = indexItem < 10 ? `0${indexItem}` : indexItem;
        option.innerText = element[0].toUpperCase() + element.substring(1);
        selectMonth.appendChild(option);
    });
}
infoDates();

saveData.addEventListener('click', add);
getDataBtn.addEventListener('click', index);
