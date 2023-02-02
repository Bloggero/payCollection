const csrf = document.querySelector('[name="_token"]').value;

function add() {
    const userName = document.querySelector("#name");
    const description = document.querySelector("#description");
    const amount = document.querySelector("#amount");
    const params = {
        type: "post",
        name: userName.value  || "Empty",
        user: selectUser.value  || "Empty",
        description: description.value  || "Empty",
        // credit_type: credit_type.value  || "Empty",
        credit_type: 'from',
        date_info: date_info.value  || "Empty",
        time_type: time_type.value  || "Empty",
        amount: amount.value  || "Empty",
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
            if (response.success) {
                $("#newUserModal").modal("hide");

                msgSweetAlert("success");

                createElement('create', response.name, response.user_id, description.value, amount.value, response.itemId);
                userName.value = '';
                description.value = '';
                amount.value = 0;
            } else {
                msgSweetAlert("error");
            }
        })
        .then(() => {});
}

function createElement(type, name, userId, description, amount, itemId) {
    const payDataDivRow = document.querySelector('#payDataDivRow');
    const paidDataDivRow = document.querySelector('#paidDataDivRow');
    
    let response = `
    <div class="col-12 col-sm-12 col-md-4 col-lg-3" id="element-${itemId}">
        <div class="card">
            <div class="card-header">
                <b>${name}</b>
                <label class="float-right"><i class="fa fa-eye showUser" aria-hidden="true"
                        id="showUser-${userId}"
                        user="${userId}"></i></label>
            </div>
            <div class="card-body">
                <p class="card-text text-muted">${description}</p>
                <hr />
                    <p class="card-text text-danger" id="amount-${itemId}">
                        <b>$${amount}</b></p>
            </div>`;
            if (type == 'create'){
                response += `<a href="javascript:void(0)" class="card-link bg-success paynow" id="a-${itemId}">`;
            }else if (type == 'update'){
                response += `<a href="javascript:void(0)" class="card-link bg-secondary" disabled="true" style="pointer-events: none;">`;
            }
            response += `
                <div class="card-footer text-center" collection="${itemId}"
                id="collection-${itemId}">Pay</div>
            </a>
        </div>
    </div>`;
    if (type == 'create'){
        payDataDivRow.innerHTML = response + payDataDivRow.innerHTML;

    }else if (type == 'update'){
        paidDataDivRow.innerHTML = response + paidDataDivRow.innerHTML;

    }

    getItemsEvent();

    return;
}

function getItemsEvent(){
    
    /*This is for every button pay for show a sweetAlert question*/
    let payItems = document.querySelectorAll(".paynow");
    payItems.forEach((element) => element.addEventListener("click", pay));

    /*This is for every button show for show modal*/
    const dashboardItems = document.querySelectorAll(".showUser");
    dashboardItems.forEach((element) => element.addEventListener("click", show));



}

function show(value) {
    const user_id = value.target.getAttribute("user");
    const params = {
        type: "get",
        user_id: user_id,
        _token: csrf
    };
    userCollectionsTable.innerHTML = '';

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
            if (response.success) {
                const items = response.items.reverse();
                const currency = function (number) {

                    return new Intl.NumberFormat("en-us", {
                        style: "currency",
                        currency: "USD",
                        minimumFractionDigits: 2,
                    }).format(number);

                };
                items.forEach((element) => {
                    let tr = '', pay = '', created = '', updated = ''; 
                    element.pay ? tr = "table-success" : tr = "table-danger";
                    pay = element.pay ? "Yes" : "No";
                    created = new Date(
                        element.created_at
                    ).toLocaleDateString();
                    updated = new Date(
                        element.updated_at
                    ).toLocaleDateString();

                    updateTableInfo(tr, pay, created, updated, currency(element.amount));

                });

                let totalAmount = response.items;
                let totalPayed = totalAmount.filter(element => element.pay == 1).reduce((sum, element) => sum + element.amount, 0);
                let totalUnpayed = totalAmount.filter(element => element.pay == 0).reduce((sum, element) => sum + element.amount, 0);

                totalAmount = totalPayed - totalUnpayed;

                updateTableInfo('table-secondary','','',`<b>Payed</b>`, `<b>${currency(totalPayed)}</b>`);
                updateTableInfo('table-secondary','','',`<b>Unpayed</b>`, `<b>${currency(totalUnpayed)}</b>`);
                updateTableInfo('table-success','','',`<b>Total</b>`, `<b>${currency(totalAmount)}</b>`);

                $("#showCardModal").modal("show");


            } else {
                msgSweetAlert("error");
            }
        })
        .then(() => {});
}

function updateTableInfo(tr, pay, created, payment, amount){
    const thisTr = document.createElement("tr");
    thisTr.classList.add(`${tr}`);
    
    const tdPay = document.createElement("td");
    tdPay.innerHTML = pay;

    const tdCreated = document.createElement("td");
    tdCreated.innerHTML = created;

    const tdPayment = document.createElement("td");
    tdPayment.innerHTML = payment;

    const tdAmount = document.createElement("td");
    tdAmount.innerHTML = amount;

    thisTr.appendChild(tdPay);
    thisTr.appendChild(tdCreated);
    thisTr.appendChild(tdPayment);
    thisTr.appendChild(tdAmount);

    userCollectionsTable.appendChild(thisTr);

    return;
}

function pay(value) {
    let collection;

    if (typeof value === 'number') {
        collection = value;

    } else {
        collection = value.target.getAttribute("collection");
    }



    const params = {
        type: "update",
        collection: collection,
        _token: csrf
    };

    Swal.fire({
        title: "Are you sure?",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Yes",
        denyButtonText: "No",
        customClass: {
            actions: "my-actions",
            cancelButton: "order-1 right-gap",
            confirmButton: "order-2",
            denyButton: "order-3",
        },
    }).then((result) => {
        if (result.value) {
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
                    if (response.success) {


                        const thisItem = document.querySelector(`#element-${collection}`);
                        thisItem.style.display = 'none';
                        createElement('update', response.name, response.user_id, response.description, response.amount, response.itemId);

                        // const thisElementId = value.target.id;
                        // document.querySelector(`#${thisElementId}`).classList.add('bg-secondary');
                        // document.querySelector(`#a-${collection}`).classList.remove('paynow');
                        // document.querySelector(`#a-${collection}`).style = "pointer-events: none;";
                        // document.querySelector(`#amount-${collection}`).classList.remove("text-danger");
                        // document.querySelector(`#amount-${collection}`).classList.add("text-success");

                        /*thisElementId is id for every collection and next we add a class bg-secondary for change color and block her pinter-events and remove paynow class for the "a" element and change text-danger for text-success in the amount*/
                        msgSweetAlert("success");
                    } else {
                        msgSweetAlert("error");
                    }
                })
                .then(() => {});
        }
    });
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

getItemsEvent();
addBtn.addEventListener("click", add);