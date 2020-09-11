class Workspace {
    constructor(app){
        this.app = app;

        this.canvas = $("#workspace canvas")[0];
        this.ctx = this.canvas.getContext("2d");
        this.ctx.fillStyle = "#fff";

        this.sliced = createCanvas(this.canvas.width, this.canvas.height);   

        this.parts = [];
        
        this.tools = {
            select: new Select(this),
            spin: new Spin(this),
            cut: new Cut(this),
            glue: new Glue(this),
        };
        this.selected = null;

        this.render();
        this.setEvents();
    }

    get tool(){
        return this.tools[this.selected];
    }
    get width(){
        return this.canvas.width;
    }
    get height(){
        return this.canvas.height;
    }

    render(){
        this.ctx.fillRect(0, 0, this.width, this.height);

        this.parts.forEach(part => {
            part.update();
            this.ctx.drawImage(part.canvas, part.x, part.y);
            
            // this.ctx.strokeRect(part.x, part.y, part.width, part.height); // debug
        });

        this.ctx.drawImage(this.sliced, 0, 0);

        requestAnimationFrame(() => this.render());
    }   

    pushPart({imageURL, width, height}){
        let image = new Image();
        image.src = imageURL;
        image.onload = () => {
            let canvas = createCanvas(width, height);
            let ctx = canvas.getContext("2d");
            ctx.drawImage(image, 0, 0, width, height);
            
            let src = new Source( ctx.getImageData(0, 0, width, height) );
            this.parts.push( new Part( src ) );
        };
    }

    setEvents(){
        $(window).on("mousedown", e => {
            if(e.which == 1 && this.tool && this.tool.onmousedown) {
                this.tool.onmousedown(e);
            }
        });
        $(window).on("mousemove", e => {
            if(e.which == 1 && this.tool && this.tool.onmousemove) {
                this.tool.onmousemove(e);
            }
        });
        $(window).on("mouseup", e => {
            if(e.which == 1 && this.tool && this.tool.onmouseup) {
                this.tool.onmouseup(e);
            }
        });
        $(window).on("dblclick", e => {
            if(e.which == 1 && this.tool && this.tool.ondblclick) {
                this.tool.ondblclick(e);
            }
        });
        $(window).on("contextmenu", e => {
            if(this.tool && this.tool.oncontextmenu) {
                e.preventDefault();
                this.tool.oncontextmenu(list => this.app.createMenu(list, e.pageX, e.pageY));
            }
        });
    }
}