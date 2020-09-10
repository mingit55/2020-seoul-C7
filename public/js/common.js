class IDB {
    constructor(dbname, stores, callback = () => {}){
        let req = indexedDB.open(dbname, 1);
        req.onupgradeneeded = () => {
            let db = req.result;
            stores.forEach(store => {
                db.createObjectStore(store, {keyPath: "id", autoIncrement: true});
            });
        };

        req.onsuccess = () => {
            this.db = req.result;
            callback(this);
        };
    }

    objectStore(storeName){
        return this.db.transaction(storeName, "readwrite").objectStore(storeName);
    }

    get(storeName, id){
        return new Promise(res => {
            let os = this.objectStore(storeName) ;
            let req = os.get(id);
            req.onsuccess = () => res(req.result);
        });
    }
    
    delete(storeName, id){
        return new Promise(res => {
            let os = this.objectStore(storeName) ;
            let req = os.delete(id);
            req.onsuccess = () => res(req.result);
        });
    }

    add(storeName, item){
        return new Promise(res => {
            let os = this.objectStore(storeName) ;
            let req = os.add(item);
            req.onsuccess = () => res(req.result);
        });
    }

    put(storeName, item){
        return new Promise(res => {
            let os = this.objectStore(storeName) ;
            let req = os.put(item);
            req.onsuccess = () => res(req.result);
        });
    }

    getAll(storeName){
        return new Promise(res => {
            let os = this.objectStore(storeName) ;
            let req = os.getAll();
            req.onsuccess = () => res(req.result);
        });
    }
}

class HashModule {
    constructor(selector, list = []){
        this.$root = $(selector);
        this.hasList = list;
        this.showList = [];
        this.index = null;
        this.tags = [];

        this.init();
        this.setEvents();
        this.update();
    }

    get focusItem(){
        return this.showList[this.index];
    }

    init(){
        this.$root.html(`<div class="hash-module">
                            <input type="hidden" class="value" value="[]" name="${this.$root.data("name")}">
                            <div class="hash-module__input">
                                #
                                <input type="text" class="input">
                                <div class="example-list">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="error fx-n2 text-red mt-2"></div>`);
        this.$input = this.$root.find(".input");
        this.$value = this.$root.find(".value");
        this.$list = this.$root.find(".example-list");
        this.$container = this.$root.find(".hash-module");
        this.$error = this.$root.find(".error");
    }
    
    update(){
        this.$list.html("");
        this.showList.forEach((item, i) => {
            this.$list.append(`<div class="example-list__item ${this.index == i ? 'active' : ''}" data-idx="${i}">#${item}</div>`);
        });

        this.$container.find(".hash-module__item").remove();
        this.tags.forEach((item, i) => {
            this.$container.append(`<div class="hash-module__item" data-idx="${i}">
                    #${item}
                    <span class="remove" data-idx="${i}">&times;</span>
                </div>`);
        });

        this.$value.val(JSON.stringify(this.tags));
    }   

    pushTag(tagname){
        if(tagname.length < 2 || 30 < tagname.length) return;
        else if(this.tags.includes(tagname)) this.$error.text("이미 추가한 태그입니다.");
        else if(this.tags.length >= 10) this.$error.text("태그는 10개까지만 추가할 수 있습니다.");
        else {
            this.tags.push(tagname);
            this.$input.val('');
            this.showList = [];
            this.index = null;
        }
    }

    setEvents(){
        this.$input.on("input", e => {
            let value = e.target.value.replace(/[^a-zA-Z0-9ㄱ-ㅎㅏ-ㅣ가-힣_]/g, "").substr(0, 30);
            e.target.value = value;

            this.$error.text('');
            this.index = null;
            if(value.length > 0 ){
                let regex = new RegExp("^" + value.replace(/([.+*?^$\[\]\(\)\\\\\\/])/g, "\\$1"));

                this.showList = [];
                this.hasList.forEach(item => {
                    if(!this.showList.includes(item) && regex.test(item)) {
                        this.showList.push(item);
                    }
                });
            }
            else {
                this.showList = [];
            }

            this.update();
        });

        this.$input.on("keydown", e => {
            if(this.index !== null && e.keyCode == 13) {
                e.preventDefault();
                this.$input.val( this.focusItem );
                this.index = null;
                this.showList = [];
            } 
            else if(e.keyCode == 13 || e.keyCode == 9 || e.keyCode == 32) {
                e.preventDefault();
                this.pushTag( this.$input.val() );
            }
            else if(e.keyCode == 38){
                this.index = this.index == null ? 0 
                    : this.index - 1 < 0 ? this.showList.length - 1
                    : this.index - 1;
            }
            else if(e.keyCode == 40){
                this.index = this.index == null ? 0 
                    : this.index + 1 >= this.showList.length ? 0
                    : this.index + 1;
            }

            this.update();
        });

        this.$container.on("click", ".remove", e => {
            let idx = parseInt( e.currentTarget.dataset.idx );
            this.tags.splice(idx, 1);
            this.$error.text('');
            this.update();
        });

        this.$list.on("click", ".example-list__item", e => {
            this.index = parseInt(e.currentTarget.dataset.idx);
            this.update();
            this.$input.focus();
        });
    }
}


function createCanvas(width, height){
    let canvas = document.createElement("canvas");
    canvas.width = width;
    canvas.height = height;
    return canvas;
}

$(function(){
    $(".custom-file-input").on("change", e => {
        let $label = $(e.target).siblings(".custom-file-label");
        let files = e.target.files;
        if(files.length > 0){
            $label.text(`${files.length}개의 파일`);
        } else {
            $label.text("파일을 선택하세요");
        }
    });

    $("[data-target]").on("click", e => {
        e.stopPropagation();

        let target = e.currentTarget.dataset.target;
        $(target).modal("show");
    });
});