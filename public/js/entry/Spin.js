class Spin extends Tool {
    constructor(){
        super(...arguments);
    }

    ondblclick(e){
        let target = this.getMouseTarget(e);

        if(!this.selected && target){
            target.active = true;

            this.selected = target;
            this.prevImage = target.src;
            this.prevSliced = createCanvas(target.width, target.height);
            let psctx = this.prevSliced.getContext("2d");
            psctx.drawImage(target.sliced, 0, 0);

            this.image = createCanvas(target.width, target.height);
            let ctx = this.image.getContext("2d");
            ctx.putImageData(target.src.imageData, 0, 0);

            this.sliced = createCanvas(target.width, target.height);
            let sctx = this.sliced.getContext("2d");
            sctx.drawImage(target.sliced, 0, 0);

            let [,,imgW, imgH] = target.src.getSize();
            let spinSize = Math.sqrt(Math.pow(imgW, 2) + Math.pow(imgH, 2));
            let imgX = (spinSize - imgW) / 2;
            let imgY = (spinSize - imgH) / 2;

            target.canvas.width = target.canvas.height = spinSize;
            target.sliced.width = target.sliced.height = spinSize;
            target.x -= imgX;
            target.y -= imgY;
            
            this.canvas = createCanvas(spinSize, spinSize);
            this.ctx = this.canvas.getContext("2d");

            this.ctx.drawImage(this.image, imgX, imgY);
            target.src = new Source( this.ctx.getImageData(0, 0, spinSize, spinSize) );
            
            target.sctx.clearRect(0, 0, spinSize, spinSize);
            target.sctx.drawImage(this.sliced, imgX, imgY);
        }
    }

    onmousedown(e){
        if(!this.selected) return;
        this.prevX = e.pageX;
    }

    onmousemove(e){
        if(!this.selected) return;
        
        let target = this.selected;
        let angle = (this.prevX - e.pageX) * Math.PI / 180;
        this.prevX = e.pageX;
        
        let center = this.canvas.width / 2;
        let imgX = center - this.image.width / 2;
        let imgY = center - this.image.height / 2;
        
        this.ctx.translate(center, center);
        this.ctx.rotate(angle);
        this.ctx.translate(-center, -center);

        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        this.ctx.drawImage(this.image, imgX ,imgY);
        target.src = new Source(this.ctx.getImageData(0, 0, this.canvas.width, this.canvas.height));

        this.ctx.clearRect(0, 0, this.canvas.width, this.canvas.height);
        this.ctx.drawImage(this.sliced, imgX ,imgY);
        target.sctx.putImageData(this.ctx.getImageData(0, 0, this.canvas.width, this.canvas.height), 0, 0);
    }

    oncontextmenu(makeFunc){
        if(!this.selected) return;
        makeFunc([
            {name: "확인", onclick: this.accept},
            {name: "취소", onclick: this.cancel},
        ]);
    }

    accept = e => {
        if(!this.selected) return;
        this.selected.recalculate();
        this.unselectAll();
    };
    
    cancel = e => {
        if(!this.selected) return;

        let target = this.selected;
        let moveX = (this.canvas.width - this.image.width) / 2;
        let moveY = (this.canvas.height - this.image.height) / 2;

        target.canvas.width = this.prevImage.width;
        target.canvas.height = this.prevImage.height;
        target.sliced.width = this.prevSliced.width;
        target.sliced.height = this.prevSliced.height;

        target.src = this.prevImage;
        target.sliced = this.prevSliced;

        target.x += moveX;
        target.y += moveY;

        this.unselectAll();
    };
}