class Tool {
    constructor(workspace){
        this.ws = workspace;
        this.selected = null;
    }

    getXY({pageX, pageY}){
        let {left, top} = $(this.ws.canvas).offset();
        let width = this.ws.width;
        let height = this.ws.height;
        
        let x = pageX - left;
        let y = pageY - top;

        return [
            x < 0 ? 0 : x > width ? width : x,
            y < 0 ? 0 : y > height ? height : y
        ];
    }

    getMouseTarget(e){
        let [x, y] = this.getXY(e);

        for(let i = this.ws.parts.length - 1; i >= 0; i--){
            let part = this.ws.parts[i];
            
            if(part.src.getColor(x - part.x, y - part.y)){
                this.ws.parts.splice(i, 1);
                this.ws.parts.push(part);

                return part;
            }
        }
        return null;
    }

    unselectAll(){
        this.selected = null;
        this.ws.parts.forEach(part => part.active = false);
    }
}