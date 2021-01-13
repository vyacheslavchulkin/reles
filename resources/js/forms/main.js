import {FormService} from "./FormService";
import {showModal} from "../functions";

$(document).ready(function () {
    $(".js-form").each(function () {
        const formNode = $(this);
        const url = formNode.attr("action");
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

                // $.post(url, data);
                // TODO заглушка
                function sleep(time) {
                    return new Promise((resolve) => setTimeout(resolve, time));
                }

                sleep(2000).then(() => {
                    formService.cleanForm();
                    showModal(data, url);
                });
            }
        });
    });
});
