import { Shape } from './shapeModule.js'
class Circle extends Shape
{
    static pi = Math.PI
    constructor(_color,_radX,_radY){
        super(_color)
        this.Rad_x=_radX
        this.Rad_y=_radY
    }
    getArea(){
        const area= Circle.pi*this.Rad_x*this.Rad_y
        return `${super.DrawShape()} and it's area is ${area} `
    }

}
export{Circle};