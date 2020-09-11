class App {
    constructor(){
        this.helps = [
            `선택 도구는 가장 기본적인 도구로써, 작업 영역 내의 한지를 선택할 수 있게 합니다. 마우스 클릭으로 한지를 활성화하여 이동시킬 수 있으며, 선택된 한지는 삭제 버튼으로 삭제시킬 수 있습니다.`,
            `회전 도구는 작업 영역 내의 한지를 회전할 수 있는 도구입니다. 마우스 더블 클릭으로 회전하고자 하는 한지를 선택하면, 좌우로 마우스를 끌어당겨 회전시킬 수 있습니다. 회전한 뒤에는 우 클릭의 콘텍스트 메뉴로 '확인'을 눌러 한지의 회전 상태를 작업 영역에 반영할 수 있습니다.`,
            `자르기 도구는 작업 영역 내의 한지를 자를 수 있는 도구입니다. 마우스 더블 클릭으로 자르고자 하는 한지를 선택하면 마우스를 움직임으로써 자르고자 하는 궤적을 그릴 수 있습니다. 궤적을 그린 뒤에는 우 클릭의 콘텍스트 메뉴로 '자르기'를 눌러 그려진 궤적에 따라 한지를 자를 수 있습니다.`,
            `붙이기 도구는 작업 영역 내의 한지들을 붙일 수 있는 도구입니다. 마우스 더블 클릭으로 붙이고자 하는 한지를 선택하면 처음 선택한 한지와 근접한 한지들을 선택할 수 있습니다. 붙일 한지를 모두 선택한 뒤에는 우 클릭의 콘텍스트 메뉴로 '붙이기'를 눌러 선택한 한지를 붙일 수 있습니다.`,
        ];
        this.findList = [];
        this.index = null;

        new IDB("seoul", ["inventory"], async db => {
            this.db = db;

            this.ws = new Workspace(this);

            this.setEvents();      
            
            let tags = (await ( fetch("/json/craftworks.json").then(res => res.json()) )).reduce((p, c) => [...p, ...c.hash_tags.map(tag => tag.substr(1))], []);
            this.insertModule = new HashModule("#insert", tags);
        });
    }

    get focusItem(){
        return this.findList[this.index];
    }

    createMenu(list, x, y){
        $(".context-menu").remove();

        let $list = $(`<div class="context-menu" style="left: ${x}px; top: ${y}px;"></div>`);
        
        list.forEach(({name, onclick}) => {
            let $item = $(`<div class="context-menu__item">${name}</div>`);
            $item.on("mousedown", onclick);
            $list.append($item);
        });
        
        $(document.body).append($list);
    }

    // 이벤트 설정
    setEvents(){
        $("[data-role].tool__item").on("click", e => {
            let role = e.currentTarget.dataset.role;

            $(".tool__item").removeClass("active");
            
            if(this.ws.tool){
                this.ws.tool.cancel && this.ws.tool.cancel();
                this.ws.tool.unselectAll();
            }
            
            if(this.ws.selected == role) this.ws.selected = null; 
            else {
                this.ws.selected = role;
                $(e.currentTarget).addClass("active");
            }
        });


        $(window).on("click", e => {
            $(".context-menu").remove();
        });

        $("[data-target='#insert-modal']").on("click", async e => {
            // let list = await this.db.getAll("inventory");
            let list = await ( fetch("/api/inventory").then(res => res.json()) );

            $("#insert-modal .row").html(``);
            list.forEach(item => {
                $("#insert-modal .row").append(`<div class="col-lg-3">
                                                    <div class="item border bg-white" data-id="${item.id}">
                                                        <img class="fit-cover hx-200" src="${item.image}" alt="상품 이미지">
                                                        <div class="p-3 border-top">
                                                            <div class="fx-3">${item.paper_name}</div>
                                                            <div class="mt-2">
                                                                <span class="fx-n2 text-muted">사이즈</span>
                                                                <span class="ml-2 fx-n1">${item.width_size}px × ${item.height_size}px</span>
                                                            </div>
                                                            <div class="mt-2">
                                                                <span class="fx-n2 text-muted">소지수량</span>
                                                                <span class="ml-2 fx-n1">${item.hasCount < 0 ? '∞' : item.hasCount}개</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`);
            });
        });

        $("#insert-modal").on("click", ".item", async e => {
            let id = e.currentTarget.dataset.id;
            let list = await ( fetch("/api/inventory").then(res => res.json()) );
            let item = list.find(item => item.id == id);
            item.hasCount--;

            if(item.hasCount == 0){
                // await this.db.delete("inventory", item.id);
                fetch("/delete/inventory/" + id);
            } else {
                // await this.db.put("inventory", item);
                $.post("/update/inventory/" + id, {count: item.hasCount});
            }

            this.ws.pushPart({imageURL: item.image, width: item.width_size, height: item.height_size});

            $("#insert-modal").modal("hide");
        });

        $(".btn-delete").on("mousedown", e => {
            if(this.ws.selected == 'select' && this.ws.tool.selected){
                this.ws.parts = this.ws.parts.filter(part => part != this.ws.tool.selected);
                this.ws.tool.unselectAll();
            } else {
                alert("한지를 선택해 주세요.");
            }
        });

        // 해시태그
        $(".help-search > .btn-search").on("click", e => search(e));
        $(".help-search > input").on("keydown", e => {
            e.keyCode == 13 && search(e);
        });
        var search = e => {
            let value = $(".help-search > input").val();
            if(value.length == 0) return;

            let regex = new RegExp( value.replace(/([.+*?^$\[\]\(\)\\\\\\/])/g, "\\$1") , "g" );
            
            this.helps.forEach((help, i) => {
                let text = help.replace(regex, m1 => `<span>${m1}</span>`);
                $(".help-body > .tab").eq(i).html( text );
            });

            this.findList = Array.from( $(".help-body > .tab > span") );
            if(this.findList.length > 0){
                this.index = 0;
                this.focusItem.classList.add("active");

                $(".help-message").text(`${this.findList.length}개 중 ${this.index + 1}번째`);
                
                let target = this.focusItem.parentElement.dataset.target;
                $("input[name='tabs']").removeAttr("checked");
                $(target).attr("checked", true);
            } else {
                this.index = null;
                $(".help-message").text("일치하는 내용이 없습니다.");
            }
        };

        $(".help-search > .btn-prev").on("click", e => {
            this.focusItem.classList.remove("active");
            this.index = this.index - 1 < 0 ? this.findList.length - 1 : this.index - 1;
            this.focusItem.classList.add("active");
            
            $(".help-message").text(`${this.findList.length}개 중 ${this.index + 1}번째`);
            
            let target = this.focusItem.parentElement.dataset.target;
            $("input[name='tabs']").removeAttr("checked");
            $(target).attr("checked", true);
        });

        $(".help-search > .btn-next").on("click", e => {
            this.focusItem.classList.remove("active");
            this.index = this.index + 1 >= this.findList.length ? 0 : this.index + 1;
            this.focusItem.classList.add("active");
            
            $(".help-message").text(`${this.findList.length}개 중 ${this.index + 1}번째`);
            
            let target = this.focusItem.parentElement.dataset.target;
            $("input[name='tabs']").removeAttr("checked");
            $(target).attr("checked", true);
        });

        $("#insert-form").on("submit", e => {
            e.preventDefault();

            if(this.ws.tool) 
                this.ws.tool.unselectAll();

            $("#image").val( this.ws.canvas.toDataURL("image/jpeg") );
            $("#insert-form")[0].submit();
        });
    }
}

$(function(){
    let app = new App();
});