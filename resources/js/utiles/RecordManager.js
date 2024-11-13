import Swal from "sweetalert2";
import {axios, EM} from "@/utiles/isayalcintr.js";
import EventManager from "@/utiles/EventManager.js";
import EventEmitter from "eventemitter3";

class RecordManager {
    constructor(el = document) {
        this.init(el);
    }

    // Kayıt silme işlemi
    async destroy({ uri, swal = { title: "Kayıt silinecek!", text: "Bu işlemin geri dönüşü yoktur! Devam etmek istiyor musunuz?" }}) {
        const self = this;
        return await Swal.fire({
            title: swal.title || '',
            text: swal.text || '',
            icon: "warning",
            confirmButtonText: "Devam Et!",
            cancelButtonText: "İptal!",
            showCancelButton: true,
            customClass: {
                icon: "rotate-y",
                confirmButton: "btn-danger",
            },
        }).then(result => {
            if (result.isDismissed) {
                console.log("İşlem iptal edildi.");
            } else {
                return axios.delete(uri)
                    .then(response => {
                        Swal.fire({
                            title: 'Kayıt silindi!',
                            text: 'İşlem başaralı',
                            icon: "success",
                            confirmButtonText: "Tamam!",
                            showCancelButton: false,
                            customClass: {
                                icon: "rotate-y",
                                confirmButton: "btn-success",
                            },
                        }).then(() => {
                            console.log(self.parentElement)
                            self.emitter.emit('rm_destroy', {
                                parentElement: self.parentElement || document,
                                data: self.responseData
                            });
                        });
                    })
                    .catch(error => {
                        Swal.fire({
                            title: 'Kayıt Eklenemedi!',
                            text: error.response && error.response.data?.message ? error.response.data?.message : "Sorry, looks like there are some errors detected, please try again.",
                            icon: "error",
                            confirmButtonText: 'Tamam!',
                            showCancelButton: false,
                            customClass: {
                                icon: "rotate-y",
                                confirmButton: "btn-danger"
                            },
                        });
                        self.emitter.emit('rm_destroy_failed', {
                            parentElement: self.parentElement || document,
                            data: self.responseData
                        });
                    });
            }
        });

    }

    // Butona tıklama olayını yönetme
    async eventButtonClick(e) {
        const deleteButton = e.target.closest('[data-kt-destroy-record-button="true"]');
        if (deleteButton) {
            const uri = deleteButton.getAttribute('data-kt-destroy-record-uri');
            if (!uri) throw new Error('destroyRecord: Uri attribute not found!');
            this.parentElement = deleteButton.getAttribute('data-kt-record-manager-parent-el');
            this.responseData = deleteButton.getAttribute('data-kt-record-manager-response-data');
            const swalTitle = deleteButton.getAttribute('data-kt-destroy-record-swal-title') || "Kayıt silinecek!";
            const swalText = deleteButton.getAttribute('data-kt-destroy-record-swal-text') || "Bu işlemin geri dönüşü yoktur! Devam etmek istiyor musunuz?";
            await this.destroy({ uri: uri, swal: { title: swalTitle, text: swalText }, element: deleteButton });
        }
    }

    // Olayları başlat
    handleButtonsClick() {
        EM.on(this.el, '[data-kt-destroy-record-button="true"]', 'click', this.eventButtonClick.bind(this));
    }

    // Olayları temizleme
    clearEvents() {
        // Tüm dinleyicileri temizle
        EM.off(this.el, '[data-kt-destroy-record-button="true"]', 'click');
    }

    // Sınıfı başlatma
    init(el = document) {
        this.el = el;
        this.handleButtonsClick();
        this.emitter = new EventEmitter();
        this.parentElement = document;
        this.responseData = 0;
    }
}

export default RecordManager;
