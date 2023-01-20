const csrf = document.querySelector('[name="_token"]').value;

function add() {
    const userName = document.querySelector("#name").value || "Empty";
    const description = document.querySelector("#description").value;
    const amount = document.querySelector("#amount").value;
    const params = {
        type: "post",
        name: userName,
        user: selectUser.value,
        description: description,
        credit_type: credit_type.value,
        date_info: date_info.value,
        time_type: time_type.value,
        amount: amount,
        extends: extends_data.checked,
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

                const container = document.createElement("div");
                container.classList.add(
                    "col-12",
                    "col-sm-12",
                    "col-md-4",
                    "col-lg-3"
                );
                const card = document.createElement("div");
                card.classList.add("card");
                const cardHeader = document.createElement("div");
                cardHeader.classList.add("card-header");
                const bUsername = document.createElement("b");
                bUsername.innerText = userName;

                if (selectUser.value != "nothing") {
                    bUsername.innerText =
                        selectUser.options[
                            selectUser.selectedIndex
                        ].getAttribute("forName");
                } else {
                    const selectOption = document.createElement("option");
                    selectOption.value = response.user_id;
                    selectOption.setAttribute("forName", `${response.name}`);
                    selectOption.innerText = `${response.name} / ${response.email}`;
                    selectUser.appendChild(selectOption);
                }

                const labelShowModal = document.createElement("label");
                labelShowModal.classList.add("float-right");

                const iconLabel = document.createElement("i");
                iconLabel.classList.add("fa", "fa-eye", "showUser");
                iconLabel.setAttribute("aria-hidden", "true");
                iconLabel.setAttribute("id", "showUser-42");
                iconLabel.setAttribute("user", "42");

                const cardBody = document.createElement("div");
                cardBody.classList.add("card-body");

                const divDescription = document.createElement("p");
                divDescription.classList.add("card-text", "text-muted");
                divDescription.innerText = description;

                const hr = document.createElement("hr");

                const divAmount = document.createElement("p");
                divAmount.classList.add("card-text", "text-danger");
                divAmount.id = `amount-${amount}`;
                
                const bAmount = document.createElement("b");
                bAmount.innerText = `$${amount}`;

                const pay = document.createElement("a");
                pay.setAttribute("href", "javascript:void(0)");
                pay.classList.add("card-link", "bg-success", "paynow");
                pay.id = `a-55`;
                
                const cardFooter = document.createElement("div");
                cardFooter.classList.add("card-footer", "text-center");
                cardFooter.setAttribute("collection", "55");
                pay.setAttribute("onClick", "pay(55)")
                cardFooter.id = `collection-55`;
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

                document.querySelector("#name").value = "";
                document.querySelector("#description").value = "";
                credit_type.value = "from";
                date_info.value = new Date();
                time_type.value = "week";
                document.querySelector("#amount").value = "";
                extends_data.checked = false;

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

function show(value) {
    const user_id = value.target.getAttribute("user");
    const params = { type: "get", user_id: user_id, _token: csrf };
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
                items.forEach((element) => {
                    const tr = document.createElement("tr");
                    const tdAmount = document.createElement("td");
                    const tdPay = document.createElement("td");
                    const tdCreated = document.createElement("td");
                    const tdPayment = document.createElement("td");
                    const amountLocal = element.amount;
                    const currency = function (number) {
                        return new Intl.NumberFormat("en-us", {
                            style: "currency",
                            currency: "USD",
                            minimumFractionDigits: 2,
                        }).format(number);
                    };
                    tdAmount.innerText = currency(amountLocal);
                    element.pay
                        ? tr.classList.add("table-success")
                        : tr.classList.add("table-danger");
                    tdPay.innerText = element.pay ? "Yes" : "No";
                    tdCreated.innerText = new Date(
                        element.created_at
                    ).toLocaleDateString();
                    tdPayment.innerText = new Date(
                        element.updated_at
                    ).toLocaleDateString();
                    const al = new Date(element.updated_at);

                    tr.appendChild(tdAmount);
                    tr.appendChild(tdPay);
                    tr.appendChild(tdCreated);
                    tr.appendChild(tdPayment);
                    userCollectionsTable.appendChild(tr);
                    $("#showCardModal").modal("show");
                });
            } else {
                msgSweetAlert("error");
            }
        })
        .then(() => {});
}

function pay(value) {
    let collection;

    if(typeof value === 'number'){
        collection = value;

    }else{
        collection = value.target.getAttribute("collection");
    }


    const params = { type: "update", collection: collection, _token: csrf };

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
                    console.log('response', response);
                    if (response.success) {
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
/*This is for every button pay for show a sweetAlert question*/
let payItems = document.querySelectorAll(".paynow");
payItems.forEach((element) => element.addEventListener("click", pay));

/*This is for every button show for show modal*/
const dashboardItems = document.querySelectorAll(".showUser");
dashboardItems.forEach((element) => element.addEventListener("click", show));

addBtn.addEventListener("click", add);


/*


let payItems = document.querySelectorAll(".paynow");
payItems.forEach((element) => element.addEventListener("click", pay));

const dashboardItems = document.querySelectorAll(".showUser");
dashboardItems.forEach((element) => element.addEventListener("click", show));

addBtn.addEventListener("click", add);




Esto hay que revisarlo ya que en el otro lado tenemos que usar 
        collection = value.target.getAttribute("collection");

        esetarget no me gusta por lo que tengo que investigar bien bien como está funcionando ya que en el html tendría que agregar el attribute especificamente en el dato que mandamos a traer desde querySelecectorAll


*/