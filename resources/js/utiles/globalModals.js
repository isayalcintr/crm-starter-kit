import createModalCustomerCreate from "@/partials/modals/customer/modal-create.js";
import createModalCustomerEdit from "@/partials/modals/customer/modal-edit.js";
import createModalInterviewCreate from "@/partials/modals/interview/modal-create.js";
import createModalTaskCreate from "@/partials/modals/task/modal-create.js";

let customerCreateModal, customerEditModal, interviewCreateModal, interviewEditModal, taskCreateModal;

const initCustomerCreate = () => {
    customerCreateModal = createModalCustomerCreate();
    customerEditModal = createModalCustomerEdit();
    interviewCreateModal = createModalInterviewCreate();
    taskCreateModal = createModalTaskCreate();
}
const initGlobalModals = () => {
    initCustomerCreate();
}
export {initGlobalModals, customerCreateModal, customerEditModal, interviewCreateModal, interviewEditModal, taskCreateModal}
