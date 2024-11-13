import {KTModal} from "../metronic/core/index";
import {
    axios,
    EM,
    initCitySelect,
    initCustomerSelect,
    initDistrictSelect,
    initGroupSelect
} from "@/utiles/isayalcintr.js";
import {initGlobalModals} from "@/utiles/globalModals.js";
import KTDom from "../metronic/core/helpers/dom";
import {findEnumWithValue, getUriWithRouteName} from "@/utiles/config.js";
import Swal from "sweetalert2";

KTModal.init();
KTModal.createInstances();
export {KTModal}

KTDom.ready(async () => {
    await initGroupSelect();
    initCitySelect();
    initDistrictSelect();
    await initCustomerSelect();
    initGlobalModals();
});



