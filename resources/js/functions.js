export function showModal(msg, label) {
    const modalWindow = $("#modal");
    const modalLabel = $("#modalLabel");
    const modalBody = $("#modalBody");

    if (label) {
        modalLabel.text(label);
    }

    modalBody.html(msg);
    modalWindow.modal("show");
}
