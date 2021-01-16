import {FormService} from "./FormService";
import {showModal} from "../functions";

$(document).ready(function () {
    const csrf = $('meta[name="csrf-token"]').attr('content');

    setInterval(function () {
        if (window.telegramBotEnaBle) {
            $(".js-telegram-del").fadeIn();
            $(".js-telegram-add").hide();
        } else {
            $(".js-telegram-add").fadeIn();
            $(".js-telegram-del").hide();
        }
    }, 300);

    $(".js-telegram-del").on("click", function () {
        const delButton = $(this);
        const url = delButton.data("action");
        if (confirm("Вы уверены?")) {
            axios({
                url: url,
                data: {"_token": csrf},
                method: "DELETE"
            }).then(response => {
                showModal(response.data.message);
                window.telegramBotEnaBle = false;
            }).catch((error) => {
                if (error.response.data.message) {
                    showModal(error.response.data.message);
                }
            });
        }
    });

    $(".js-form-telegram-add").on("submit", function (e) {
        e.preventDefault();
        const formNode = $(this);
        const url = formNode.attr("action");
        const data = formNode.serialize();
        const method = formNode.attr("method");
        const formService = new FormService(formNode);
        if (formService.isValidForm()) {
            formService.disableAllElements();
            axios({url: url, data: data, method: method}).then(response => {
                formService.cleanForm();
                window.telegramBotEnaBle = true;
                showModal(response.data.message);
            }).catch((error) => {
                formService.disableForm();
                formService.enableAllElements();
                if (error.response.data.message) {
                    showModal(error.response.data.message);
                }
                let errors = error.response.data.errors;
                formService.showErrors(errors);
            });
        }
    });
});
