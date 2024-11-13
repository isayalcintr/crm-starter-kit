import $ from "jquery";

const domLayout = "<'table-body't><'dataTable-bottom'<'dataTable-per-page per-page'l><'dataTable-page-info info'i><'dataTable-pagination pagination'p>>";
export {domLayout};



//3 fonksiyonu artık kullanma!
const customPagination = () => {
    const pagination = $('.dt-paging nav[aria-label="pagination"]');
    if (pagination.length) {
        pagination.addClass('pagination');
        pagination.find('button').addClass('btn');
        pagination.find('button:first-child').html('<i class="ki-outline ki-black-left"></i>');
        pagination.find('button:last-child').html('<i class="ki-outline ki-black-right"></i>');
        pagination.find('button.current').addClass('active disabled');
        pagination.find('button.disabled').addClass('disabled');
    }
}
export {customPagination}

const headerCallback = function (thead, data, start, end, display, tableEl) {
    $(thead).find('th').each(function(index) {
        const column = $(tableEl).DataTable().column(index);
        const columnName = $(this).text().trim();
        if (column.orderable()) {
            $(this).html(`
                <span class="sort">
                    <span class="sort-label">
                        ${columnName}
                    </span>
                    <span class="sort-icon"></span>
                </span>
            `);
        } else {
            $(this).text(columnName);
        }
    });
};
export {headerCallback}

const drawCallback = (datatable, settings) => {
    customPagination();
    const order = datatable.api().order();
    datatable.api().columns().every(function(index) {
        const columnHeader = this.header();
        const isSortedAsc = (order[0][0] === index && order[0][1] === 'asc');
        const isSortedDesc = (order[0][0] === index && order[0][1] === 'desc');
        $(columnHeader).find('.sort').removeClass('asc desc');
        if (isSortedAsc) {
            $(columnHeader).find('.sort').addClass('asc');
        } else if (isSortedDesc) {
            $(columnHeader).find('.sort').addClass('desc');
        }
    });
}
export {drawCallback}

const dataTableTRLang = {
    "emptyTable": "Tabloda herhangi bir veri mevcut değil",
    "info": "_TOTAL_ kayıttan _START_ - _END_ arasındaki kayıtlar gösteriliyor",
    "infoEmpty": "Kayıt yok",
    "infoFiltered": "(_MAX_ kayıt içerisinden bulunan)",
    "infoThousands": ".",
    "lengthMenu": "Sayfada _MENU_ kayıt göster",
    "loadingRecords": "Yükleniyor...",
    "processing": `<div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2" data-datatable-spinner="true">
            <div class="flex items-center gap-2 px-4 py-2 font-medium leading-none text-2sm border border-gray-200 shadow-default rounded-md text-gray-500 bg-light">
                <svg class="animate-spin -ml-1 h-5 w-5 text-gray-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="3"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading...
            </div>
        </div>`,
    "search": "Ara:",
    "zeroRecords": "Eşleşen kayıt bulunamadı",
    "paginate": {
        "first": "<i class='first'></i>",
        "last": "<i class='last'></i>",
        "next": "<i class='next'></i>",
        "previous": "<i class='previous'></i>"
    },
    "aria": {
        "sortAscending": ": artan sütun sıralamasını aktifleştir",
        "sortDescending": ": azalan sütun sıralamasını aktifleştir"
    },
    "select": {
        "rows": {
            "_": "%d kayıt seçildi",
            "1": "1 kayıt seçildi"
        }
    },
    "autoFill": {
        "cancel": "İptal",
        "fillHorizontal": "Hücreleri yatay olarak doldur",
        "fillVertical": "Hücreleri dikey olarak doldur",
        "fill": "Bütün hücreleri <i>%d<\/i> ile doldur"
    },
    "buttons": {
        "collection": "Koleksiyon <span class=\"ui-button-icon-primary ui-icon ui-icon-triangle-1-s\"><\/span>",
        "colvis": "Sütun görünürlüğü",
        "colvisRestore": "Görünürlüğü eski haline getir",
        "copySuccess": {
            "1": "1 satır panoya kopyalandı",
            "_": "%ds satır panoya kopyalandı"
        },
        "copyTitle": "Panoya kopyala",
        "csv": "CSV",
        "excel": "Excel",
        "pageLength": {
            "-1": "Bütün satırları göster",
            "_": "%d satır göster"
        },
        "pdf": "PDF",
        "print": "Yazdır",
        "copy": "Kopyala",
        "copyKeys": "Tablodaki veriyi kopyalamak için CTRL veya u2318 + C tuşlarına basınız. İptal etmek için bu mesaja tıklayın veya escape tuşuna basın."
    },
    "searchBuilder": {
        "add": "Koşul Ekle",
        "button": {
            "0": "Arama Oluşturucu",
            "_": "Arama Oluşturucu (%d)"
        },
        "condition": "Koşul",
        "conditions": {
            "date": {
                "after": "Sonra",
                "before": "Önce",
                "between": "Arasında",
                "empty": "Boş",
                "equals": "Eşittir",
                "not": "Değildir",
                "notBetween": "Dışında",
                "notEmpty": "Dolu"
            },
            "number": {
                "between": "Arasında",
                "empty": "Boş",
                "equals": "Eşittir",
                "gt": "Büyüktür",
                "gte": "Büyük eşittir",
                "lt": "Küçüktür",
                "lte": "Küçük eşittir",
                "not": "Değildir",
                "notBetween": "Dışında",
                "notEmpty": "Dolu"
            },
            "string": {
                "contains": "İçerir",
                "empty": "Boş",
                "endsWith": "İle biter",
                "equals": "Eşittir",
                "not": "Değildir",
                "notEmpty": "Dolu",
                "startsWith": "İle başlar"
            },
            "array": {
                "contains": "İçerir",
                "empty": "Boş",
                "equals": "Eşittir",
                "not": "Değildir",
                "notEmpty": "Dolu",
                "without": "Hariç"
            }
        },
        "data": "Veri",
        "deleteTitle": "Filtreleme kuralını silin",
        "leftTitle": "Kriteri dışarı çıkart",
        "logicAnd": "ve",
        "logicOr": "veya",
        "rightTitle": "Kriteri içeri al",
        "title": {
            "0": "Arama Oluşturucu",
            "_": "Arama Oluşturucu (%d)"
        },
        "value": "Değer",
        "clearAll": "Filtreleri Temizle"
    },
    "searchPanes": {
        "clearMessage": "Hepsini Temizle",
        "collapse": {
            "0": "Arama Bölmesi",
            "_": "Arama Bölmesi (%d)"
        },
        "count": "{total}",
        "countFiltered": "{shown}\/{total}",
        "emptyPanes": "Arama Bölmesi yok",
        "loadMessage": "Arama Bölmeleri yükleniyor ...",
        "title": "Etkin filtreler - %d"
    },
    "thousands": ".",
    "datetime": {
        "amPm": [
            "öö",
            "ös"
        ],
        "hours": "Saat",
        "minutes": "Dakika",
        "next": "Sonraki",
        "previous": "Önceki",
        "seconds": "Saniye",
        "unknown": "Bilinmeyen",
        "weekdays": {
            "6": "Paz",
            "5": "Cmt",
            "4": "Cum",
            "3": "Per",
            "2": "Çar",
            "1": "Sal",
            "0": "Pzt"
        },
        "months": {
            "9": "Ekim",
            "8": "Eylül",
            "7": "Ağustos",
            "6": "Temmuz",
            "5": "Haziran",
            "4": "Mayıs",
            "3": "Nisan",
            "2": "Mart",
            "11": "Aralık",
            "10": "Kasım",
            "1": "Şubat",
            "0": "Ocak"
        }
    },
    "decimal": ",",
    "editor": {
        "close": "Kapat",
        "create": {
            "button": "Yeni",
            "submit": "Kaydet",
            "title": "Yeni kayıt oluştur"
        },
        "edit": {
            "button": "Düzenle",
            "submit": "Güncelle",
            "title": "Kaydı düzenle"
        },
        "error": {
            "system": "Bir sistem hatası oluştu (Ayrıntılı bilgi)"
        },
        "multi": {
            "info": "Seçili kayıtlar bu alanda farklı değerler içeriyor. Seçili kayıtların hepsinde bu alana aynı değeri atamak için buraya tıklayın; aksi halde her kayıt bu alanda kendi değerini koruyacak.",
            "noMulti": "Bu alan bir grup olarak değil ancak tekil olarak düzenlenebilir.",
            "restore": "Değişiklikleri geri al",
            "title": "Çoklu değer"
        },
        "remove": {
            "button": "Sil",
            "confirm": {
                "_": "%d adet kaydı silmek istediğinize emin misiniz?",
                "1": "Bu kaydı silmek istediğinizden emin misiniz?"
            },
            "submit": "Sil",
            "title": "Kayıtları sil"
        }
    }
}
export {dataTableTRLang}
