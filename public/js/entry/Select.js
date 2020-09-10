class Select extends Tool {
    constructor(){
        super(...arguments);
    }

    onmousedown(e){
        this.unselectAll();
        
        let target = this.getMouseTarget(e);
        if(target){
            target.active = true;
            this.selected = target;
            this.downTarget = target;

            this.firstXY = [target.x, target.y];
            this.downXY = this.getXY(e);
        }
    }

    onmousemove(e){
        if(!this.downTarget) return;

        let [x, y] = this.getXY(e);
        let [fx, fy] = this.firstXY;
        let [dx, dy] = this.downXY;

        this.selected.x = fx + x - dx;
        this.selected.y = fy + y - dy;
    }

    onmouseup(){
        if(!this.downTarget) return;
        this.downTarget = null;
    }
}