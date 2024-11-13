import { formValidTypes, checkValidFormType, axios } from "@/utiles/isayalcintr.js";
import {getUriWithRouteName, SystemData} from "@/utiles/config.js";
import EventEmitter from "eventemitter3";
import * as Yup from 'yup';
import createYupForm from "@/utiles/yupForm.js";
import $ from "jquery";
const createGroupForm = ({ formSelector, type = formValidTypes.other }) => {
    const formEl = document.querySelector(formSelector);
    const yupForm = createYupForm({formEl: formEl});
    const emitter = new EventEmitter();
    const validationSchema = Yup.object().shape({
        title: Yup.string().required('Başlık girilmesi zorunludur!'),
        order: Yup.number().required('Sıra girilmesi zorunludur!'),
        section: Yup.number().required('Bölüm seçilmesi zorunludur!'),
        type: Yup.number().required('Tip seçilmesi zorunludur!'),
    });
    const initForm = () => {
        if (!checkValidFormType(type)) throw new Error("Type is not valid!");
        if (!formEl) throw new Error("Form element not found!");
        initTypes();
        handleSubmit();
        handleSectionChange();
    }

    const handleSectionChange = () => {
        formEl.querySelector('select[name="section"]').addEventListener('change', (e) => {
            initTypes();
        });
    }

    const initTypes = () => {
        const sectionEl = formEl.querySelector('select[name="section"]');
        const typeEl = formEl.querySelector('select[name="type"]');
        typeEl.innerHTML = "";
        $(typeEl).val('');
        const enums = SystemData?.Enums["GroupType"].filter(item => item.parent.value === parseInt($(sectionEl).val()));
        enums.forEach(item => {
            $(typeEl).append(`<option value="${item.value}">${item.title}</option>`);
        });
    }

    const handleSubmit = () => {
        formEl.addEventListener('submit', async e => {
            e.preventDefault();
            switch (type) {
                case formValidTypes.create:
                    await store();
                    break;
                case formValidTypes.edit:
                    await update();
                    break;
                default:
                    console.warn("Unknown form type!");
            }
        });
    }

    const store = async () => {
        const formData = new FormData(formEl);
        const data = Object.fromEntries(formData.entries());
        yupForm.clearErrorMessages();
        try {
            await validationSchema.validate(data, { abortEarly: false });
            emitter.emit('store_loading', true);
            await axios.post(getUriWithRouteName({ name: 'group.store' }), formData)
                .then(response => {
                    emitter.emit('store_success', response);
                })
                .catch(error => {
                    emitter.emit('store_error', error);
                })
                .finally(() => {
                    emitter.emit('store_loading', false);
                });
        } catch (err) {
            yupForm.displayErrors(err);
            emitter.emit('validation_failed', err);
        }
    }

    const setFormData = (data) => {
        $(formEl.querySelector('input[name="title"]')).val(data?.title).trigger('change');
        $(formEl.querySelector('input[name="order"]')).val(data?.order).trigger('change');
        $(formEl.querySelector('select[name="section"]')).val(data?.section).trigger('change');
        $(formEl.querySelector('select[name="type"]')).html(`<option value="${data?.type}" selected>${data?.type_title}</option>`).trigger('change');
    }

    const edit = async (group) => {
        await axios.get(getUriWithRouteName({ name: 'group.show', params: {group: group} }))
            .then(response => {
                setFormData(response.data.data);
                return response;
            })
            .catch(error => {
                setFormData({});
                throw new Error(error);
            });
    }

    const update = async (group) => {
        const formData = new FormData(formEl);
        const data = Object.fromEntries(formData.entries());
        yupForm.clearErrorMessages();
        try {
            await validationSchema.validate(data, { abortEarly: false });
            emitter.emit('update_loading', true);
            await axios.put(getUriWithRouteName({ name: 'group.update', params: {group: group} }), data)
                .then(response => {
                    emitter.emit('update_success', response);
                })
                .catch(error => {
                    emitter.emit('update_error', error);
                })
                .finally(() => {
                    emitter.emit('update_loading', false);
                });
        } catch (err) {
            yupForm.displayErrors(err);
            emitter.emit('validation_failed', err);
        }
    }

    initForm();
    return {
        formEl: formEl,
        store: store,
        edit: edit,
        update: update,
        emitter: emitter,
        setFormData: setFormData,
    }
}
export default createGroupForm;
