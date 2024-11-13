import { formValidTypes, checkValidFormType, axios } from "@/utiles/isayalcintr.js";
import { getUriWithRouteName } from "@/utiles/config.js";
import EventEmitter from "eventemitter3";
import * as Yup from 'yup';
import createYupForm from "@/utiles/yupForm.js";

const createUserForm = ({ formSelector, type = formValidTypes.other }) => {
    const formEl = document.querySelector(formSelector);
    const yupForm = createYupForm({formEl: formEl});
    const emitter = new EventEmitter();
    let validationSchema = Yup.object().shape({
        name: Yup.string().required('Ad girilmesi zorunludur!'),
        surname: Yup.string().required('Soyad girilmesi zorunludur!'),
        email: Yup.string().required('e-Posta girilmesi zorunludur!').email('Geçerli bir email adresi giriniz!'),
        role_id: Yup.number().required('Erişi yetkisi seçilmesi zorunludur!'),
    });
    const initForm = () => {
        if (!checkValidFormType(type)) throw new Error("Type is not valid!");
        if (!formEl) throw new Error("Form element not found!");
        if (type === formValidTypes.create) {
            validationSchema = validationSchema.concat(
                Yup.object().shape({
                    password: Yup.string()
                        .required('Şifre girilmesi zorunludur!')
                        .min(8, 'Şifre en az 8 karakter olmalıdır!')
                        .matches(/[a-z]/, 'Şifre en az bir küçük harf içermelidir!')
                        .matches(/[A-Z]/, 'Şifre en az bir büyük harf içermelidir!')
                        .matches(/\d/, 'Şifre en az bir rakam içermelidir!')
                        .matches(/[@$!%*?&]/, 'Şifre en az bir özel karakter içermelidir!'),
                })
            );
        }
        else if (type === formValidTypes.edit) {
            validationSchema = validationSchema.concat(
                Yup.object().shape({
                    password: Yup.string()
                        .nullable() // Şifre boş olabilir
                        .min(8, 'Şifre en az 8 karakter olmalıdır!')
                        .matches(/[a-z]/, 'Şifre en az bir küçük harf içermelidir!', { excludeEmptyString: true })
                        .matches(/[A-Z]/, 'Şifre en az bir büyük harf içermelidir!', { excludeEmptyString: true })
                        .matches(/\d/, 'Şifre en az bir rakam içermelidir!', { excludeEmptyString: true })
                        .matches(/[@$!%*?&]/, 'Şifre en az bir özel karakter içermelidir!', { excludeEmptyString: true }),
                })
            );
        }
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
            await axios.post(getUriWithRouteName({ name: 'user.store' }), formData)
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

    const update = async (user) => {
        const formData = new FormData(formEl);
        const data = Object.fromEntries(formData.entries());
        yupForm.clearErrorMessages();
        try {
            await validationSchema.validate(data, { abortEarly: false });
            emitter.emit('update_loading', true);
            await axios.put(getUriWithRouteName({ name: 'user.update', params: {user: user} }), data)
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
export default createUserForm;
