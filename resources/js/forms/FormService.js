export class FormService {
    constructor(form) {
        this.form = form;
        this.button = form.find(".js-form-send");
    }


    enableForm() {
        this.form.data("active", true);
    }


    disableForm() {
        this.form.data("active", false);
    }


    isValidForm() {
        let isValidFields = true;

        this.form.find("input[type='email']").each(function () {
            if (!FormService.isValidEmail($(this))) {
                isValidFields = false;
            }
        });

        this.form.find("[required]").each(function () {
            if (!FormService.checkRequired($(this))) {
                isValidFields = false;
            }
        });

        if (isValidFields) {
            this.enableButton();
        } else {
            this.disableButton();
        }

        return isValidFields;
    }


    disableAllElements() {
        this.form.find("input, textarea").each(function () {
            $(this).prop("readonly", true);
        });
        this.disableButton();
    }


    enableAllElements() {
        this.form.find("input, textarea").each(function () {
            $(this).prop("readonly", false);
        });
        this.enableButton();
    }


    disableButton() {
        this.button.addClass("disabled");
    }


    cleanForm() {
        this.form.get(0).reset();
        this.enableAllElements();
        this.disableForm();
    }


    enableButton() {
        this.button.removeClass("disabled");
    }


    showErrors(errors){
        if (Object.keys(errors).length > 0) {
            for (let key of Object.keys(errors)) {
                this.form.find("[name=" + key + "]").each(function (){
                    FormService.addErrorLabel($(this), errors[key])
                });
            }
        }
    }

    static checkRequired(inputNode) {
        if (inputNode.val().length < 1) {
            this.addErrorLabel(inputNode, "Это поле обязательно для заполнения");
            return false;
        }
        this.removeErrorLabel(inputNode);
        return true;
    }


    static isValidEmail(emailNode) {
        let reg = /^(\S)+@([\S])+\.([\S]{1,20})$/;
        let value = emailNode.val();

        if (value.length < 1 || !reg.test(value)) {
            this.addErrorLabel(emailNode, "Некорректный email");
            return false;
        }
        this.removeErrorLabel(emailNode);
        return true;
    }


    static addErrorLabel(element, msg) {
        if (msg) {
            element.siblings(".invalid-feedback").text(msg);
        }
        element.addClass("is-invalid");
    }


    static removeErrorLabel(element) {
        element.siblings(".invalid-feedback").text("");
        element.removeClass("is-invalid");
    }
}
