import { formValidTypes, checkValidFormType, axios } from "@/utiles/isayalcintr.js";
import { getUriWithRouteName } from "@/utiles/config.js";
import EventEmitter from "eventemitter3";
import * as Yup from 'yup';
import createYupForm from "@/utiles/yupForm.js";

const createRoleForm = ({ formSelector, type = formValidTypes.other }) => {
    const formEl = document.querySelector(formSelector);
    const yupForm = createYupForm({formEl: formEl});
    const emitter = new EventEmitter();
    const validationSchema = Yup.object().shape({
        name: Yup.string().required('Başlık girilmesi zorunludur!'),
    });
    const initForm = () => {
        if (!checkValidFormType(type)) throw new Error("Type is not valid!");
        if (!formEl) throw new Error("Form element not found!");
        handleSubmit();
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
            await axios.post(getUriWithRouteName({ name: 'role.store' }), formData)
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

    const update = async (role) => {
        const formData = new FormData(formEl);
        const data = {};
        for (const [key, value] of formData.entries()) {
            if (key === 'permissions[]') {
                if (!data.permissions) {
                    data.permissions = [];
                }
                data.permissions.push(value);
            } else {
                data[key] = value;
            }
        }
        if (!data.permissions) {
            data.permissions = [];
        }
        yupForm.clearErrorMessages();
        try {
            await validationSchema.validate(data, { abortEarly: false });
            emitter.emit('update_loading', true);
            await axios.put(getUriWithRouteName({ name: 'role.update', params: {role: role} }), data)
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
        update: update,
        emitter: emitter,
    }
}
export default createRoleForm;
