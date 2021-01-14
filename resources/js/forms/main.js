import {FormService} from "./FormService";
import {showModal} from "../functions";

$(document).ready(function () {
    $(".js-form").each(function () {
        const formNode = $(this);
        const url = formNode.attr("action");
        const method = formNode.attr("method");
        const formService = new FormService(formNode);
        let isValidForm = false;
        setInterval(function () {
            if (formNode.data("active")) {
                isValidForm = formService.isValidForm();
            }
        }, 300);

        formNode.on("click", function () {
            formService.enableForm();
        });

        formNode.on("submit", function (e) {
            e.preventDefault();
            if (isValidForm) {
                const data = formNode.serialize();
                formService.disableAllElements();
                axios({url: url, data: data, method: method}).then(response => {
                    formService.cleanForm();
                    showModal(response.data.message);
                }).catch((error) => {
                    formService.disableForm();
                    formService.enableAllElements();
                    let errors = error.response.data.errors;
                    formService.showErrors(errors);
                });
            }
        });
    });
});
