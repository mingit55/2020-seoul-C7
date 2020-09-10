const UID = document.querySelector("#uid").value;

class App {
    constructor(){
        new IDB("seoul", ["papers", "inventory"], async db => {
            this.db = db;
            this.papers = await this.getPapers();
            this.cartList = [];
            this.searches = [];

            this.updateCart();
            this.updateStore();
            this.setEvents();

            this.tags = this.papers.reduce((p, c) => [...p, ...c.hash_tags], []);
            this.searchModule = new HashModule("#search", this.tags);
            this.insertModule = new HashModule("#insert", this.tags);
        }); 
    }

    get totalPoint(){
        return this.cartList.reduce((p, c) => p + c.totalPoint, 0);
    }

    get totalCount(){
        return this.cartList.reduce((p, c) => p + c.buyCount, 0);   
    }

    async getPapers(){
        let papers = await( fetch("/api/papers").then(res => res.json()) );
        // let papers = await this.db.getAll("papers");

        // if(papers.length === 0){
        //     papers = (await ( fetch("/json/papers.json").then(res => res.json()) ))
        //         .map(paper => ({
        //             ...paper,
        //             id: parseInt(paper.id),
        //             width_size: parseInt( paper.width_size.replace(/[^0-9]/g, "") ),
        //             height_size: parseInt( paper.height_size.replace(/[^0-9]/g, "") ),
        //             point: parseInt( paper.point.replace(/[^0-9]/g, "") ),
        //             image: "/images/papers/" + paper.image,
        //             hash_tags: paper.hash_tags.map(tag => tag.substr(1))
        //         }));

        //     papers.forEach(paper => {
        //         this.db.add("papers", paper);
        //     });
        // }

        return papers.map(paper => new Paper(paper));
    }

    updateStore(){
        let viewList = this.papers;

        if(this.searches.length > 0){
            viewList = viewList.filter(item => this.searches.every(tag => item.hash_tags.includes(tag)));
        }

        $("#store").html('');
        viewList.forEach(item => {
            item.update();
            $("#store").append(item.$storeElem);
        });
    }

    updateCart(){
        $("#cart").html('');
        this.cartList.forEach(item => {
            item.update();
            $("#cart").append(item.$cartElem);
        });
        
        $("#total").text( this.totalPoint.toLocaleString() );
        $("#cartList").val(JSON.stringify(this.cartList));
        $("#totalCount").val(this.totalCount);
        $("#totalPoint").val(this.totalPoint);
    }

    setEvents(){
        $("#image").on("change", e => {
            let file = e.target.files.length > 0 ? e.target.files[0] : null;

            if(!file)  
                alert("이미지를 업로드 하세요");
            else if(!["jpg", "png", "gif"].includes(file.name.substr(-3).toLowerCase())) {
                alert("이미지 파일만 업로드 가능합니다");
                e.target.value = "";
            }
            else if(file.size > 1024 * 1024 * 5) {
                alert("이미지 파일은 5MB를 넘을 수 없습니다.");   
                e.target.value = "";
            }
            else {
                let reader = new FileReader();
                reader.onload = () => {
                    $("#base64").val( reader.result );
                };
                reader.readAsDataURL(file);
            }
        });

        $("#insert-form").on("submit", async e => {
            // e.preventDefault();

            // let paper = Array.from( $("#insert-form input[name]") ).reduce((p, c) => {
            //     p[c.name] = c.value;
            //     return p;
            // }, {});

            // paper.width_size = parseInt(paper.width_size);
            // paper.height_size = parseInt(paper.height_size);
            // paper.point = parseInt(paper.point);
            // paper.hash_tags = JSON.parse(paper.hash_tags);

            // paper.id = await this.db.add("papers", paper);
            // this.papers.push( new Paper(paper) );
            // this.tags.push(...paper.hash_tags);
            // this.updateStore();

            // $("#insert-form").modal("hide");
            // $("#insert-form input").val('');
        });

        $("#store").on("click", ".btn-insert", e => {
            let paper = this.papers.find(item => item.id == e.currentTarget.dataset.id);
            paper.buyCount++;

            if(!this.cartList.includes(paper)){
                this.cartList.push(paper);
            }

            this.updateStore();
            this.updateCart();
        });

        $("#cart").on("input", ".buy-count", e => {
            let value = parseInt(e.target.value);
            if(isNaN(value) || value < 1) value = 1;
            else if(value > 1000) value = 1000;
            e.target.value = value;

            let paper = this.papers.find(item => item.id == e.currentTarget.dataset.id);
            paper.buyCount = value;

            this.updateCart();
            this.updateStore();

            e.target.focus();
        });

        $(".btn-search").on("click", e => {
            this.searches = this.searchModule.tags;
            this.updateStore();
        });

        $("#cart").on("click", ".btn-delete", e => {
            let paper = this.cartList.find(item => item.id == e.currentTarget.dataset.id);
            paper.buyCount = 0;
            this.cartList = this.cartList.filter(item => item != paper);
            
            this.updateCart();
            this.updateStore();
        });

        $("#buy-form").on("submit", async e => {
            // e.preventDefault();
            // alert(`총 ${this.totalCount}개의 한지가 구매되었습니다.`);
            
            // await Promise.all(this.cartList.map(async cartItem => {
            //     let item = await this.db.get("inventory", cartItem.id);

            //     if(item){
            //         item.hasCount += cartItem.buyCount;
            //         await this.db.put("inventory", item);
            //     }
            //     else {
            //         let {id, paper_name, image, width_size, height_size, buyCount} = cartItem;
            //         await this.db.add("inventory", {id, paper_name, image, width_size, height_size, hasCount: buyCount});
            //     }

            //     cartItem.buyCount = 0;
            // }));

            // this.cartList = [];
            // this.updateStore();
            // this.updateCart();
        });
    }
}


class Paper {
    constructor({id, image, paper_name, company_name, width_size, height_size, point, hash_tags, uid}){
        this.id = id;
        this.image = image;
        this.paper_name = paper_name;
        this.company_name = company_name;
        this.width_size = width_size;
        this.height_size = height_size;
        this.point = point;
        this.hash_tags = hash_tags;
        this.uid = uid;

        this.buyCount = 0;

        this.$storeElem = $(`<div class="col-lg-3 mb-4">
                                <div class="bg-white border">
                                    <img class="fit-cover hx-200" src="${this.image}" alt="상품 이미지">
                                    <div class="p-3 border-top">
                                        <div class="fx-3">${this.paper_name}</div>
                                        <div class="mt-2">
                                            <span class="fx-n2 text-muted">업체명</span>
                                            <span class="fx-n1 ml-2">${this.company_name}</span>
                                        </div>
                                        <div class="mt-2">
                                            <span class="fx-n2 text-muted">사이즈</span>
                                            <span class="fx-n1 ml-2">${this.width_size.toLocaleString()}px × ${this.height_size.toLocaleString()}px</span>
                                        </div>
                                        <div class="mt-2">
                                            <span class="fx-n2 text-muted">포인트</span>
                                            <span class="fx-n1 ml-2">${this.point}p</span>
                                        </div>
                                        <div class="mt-2 text-muted d-flex flex-wrap">
                                            ${this.hash_tags.map(tag => `<span class="m-1">#${tag}</span>`).join('')}
                                        </div>
                                        ${
                                            this.uid == UID ? ''
                                            : `<button class="btn-filled mt-3 btn-insert" data-id="${this.id}">구매하기</button>`
                                        }
                                        
                                    </div>
                                </div>
                            </div>`);
    
        this.$cartElem = $(`<div class="t-row">
                                <div class="cell-50">
                                    <div class="align-center">
                                        <img src="${this.image}" alt="상품 이미지" width="80" height="80">
                                        <div class="ml-4 text-left">
                                            <div class="fx-3">${this.paper_name}</div>
                                            <div class="fx-n1 text-muted mt-2">
                                                ${this.company_name}
                                                <span class="mx-1">·</span>
                                                ${this.point.toLocaleString()}p
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="cell-20">
                                    <input type="number" class="buy-count" min="1" value="1" data-id="${this.id}">
                                </div>
                                <div class="cell-20">
                                    <span class="total">${this.totalPoint.toLocaleString()}</span>p
                                </div>
                                <div class="cell-10">
                                    <button class="btn-filled btn-delete" data-id="${this.id}">삭제</button>
                                </div>
                            </div>`);
    }

    get totalPoint(){
        return this.point * this.buyCount;
    }

    update(){
        this.$storeElem.find(".btn-insert").text( this.buyCount > 0 ? `추가하기(${this.buyCount.toLocaleString()}개)` : "구매하기" );
        this.$cartElem.find(".buy-count").val(this.buyCount);
        this.$cartElem.find(".total").text(this.totalPoint.toLocaleString());
    }
}

$(function(){
    let app = new App();
});