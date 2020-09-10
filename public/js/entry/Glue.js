class Glue extends Tool {
    constructor(){
        super(...arguments);
        this.glueList = [];
    }

    ondblclick(e){
        let target = this.getMouseTarget(e);
        
        if(target && !this.selected){
            target.active = true;
            this.selected = target;
            this.glueList.push(target);
        }
    }

    onmousedown(e){
        if(!this.selected) return;

        let target = this.getMouseTarget(e);

        if(target && this.selected.isNear(target)){
            target.active = true;
            this.glueList.push(target);
        }
    }

    oncontextmenu(makeFunc){
        if(!this.selected) return;
        makeFunc([
            {name: "붙이기", onclick: this.accept},
            {name: "취소", onclick: this.cancel},
        ]);
    }

    accept = e => {
        if(!this.selected) return;

        let first = this.glueList[0];
        let left = this.glueList.reduce((p, c) => Math.min(p, c.x), first.x);
        let top = this.glueList.reduce((p, c) => Math.min(p, c.y), first.y);
        let right = this.glueList.reduce((p, c) => Math.max(p, c.x + c.width), first.x + first.width);
        let bottom = this.glueList.reduce((p, c) => Math.max(p, c.y + c.height), first.y + first.height);

        let X = left;
        let Y = top;
        let W = right - left + 1;
        let H = bottom - top + 1;

        let src = new Source( new ImageData(W, H) );
        let sliced = createCanvas(W, H);
        let sctx = sliced.getContext("2d");

        this.ws.parts = this.ws.parts.filter(part => !this.glueList.includes(part));

        this.glueList.forEach(item => {
            sctx.drawImage(item.sliced, item.x - X, item.y - Y);

            for(let y = item.y; y < item.y + item.height; y ++){
                for(let x = item.x; x < item.x + item.width; x ++){
                    let color = item.src.getColor(x - item.x, y - item.y);
                    if(color){
                        src.setColor(x - X, y - Y, color);
                    }
                }
            }
        });

        let part = new Part(src);
        part.src = src;
        part.sliced = sliced;
        part.sctx = sctx;
        part.x = X;
        part.y = Y;
        part.recalculate();
        
        this.ws.parts.push(part);

        this.cancel();
    }

    cancel = e => {
        this.glueList = [];
        this.unselectAll();
    }
}