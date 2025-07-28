
 export class Shape{
    #color='black'
    constructor(_color){
        if (new.target.name == "Shape") {
            throw Error("Sorry , Abstract Class , you can't create an object from it !!!!");
                }
                this.COLOR=_color
        
    }
    set COLOR(_color) {
        
        if (_color.constructor.name === "String") {
            
 const colorRegex = /^#([0-9a-f]{3}|[0-9a-f]{6})$|^rgb\((\d{1,3},\s*){2}\d{1,3}\)$|^rgba\((\d{1,3},\s*){3}(0|1|0?\.\d+)\)$|^(red|green|blue|black|white|yellow|pink|gray|grey|purple|orange|brown)$/i;


            if (colorRegex.test(_color)) {
                this.#color = _color;
            }
            else{
                console.log("not a color")
            }
        }

    }
    get COLOR(){
        return this.#color;
    }
    DrawShape(){
        return `shape color is ${this.COLOR}`
    }
}
