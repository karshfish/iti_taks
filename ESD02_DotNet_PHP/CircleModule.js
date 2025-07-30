import { Shape } from './shapeModule.js'
class Circle extends Shape
{
    #name
    static pi = Math.PI
    constructor(_color,_radX,_radY){
        super(_color)
        this.Rad_x=_radX
        this.Rad_y=_radY
        this.#name= new.target.name
    }
    getArea(){
        
        const area= Circle.pi*this.Rad_x*this.Rad_y
        return `${this.#name}=> ${super.DrawShape()} and it's area is ${area} `
    }

}
export{Circle};