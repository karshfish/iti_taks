import { Shape  } from "./shapeModule.js";

export class Rectangle extends Shape {
    width=0
    height=0
    #name
constructor(_color,_width,_height){
    super(_color)
    this.width=_width
    this.height=_height
    this.#name= new.target.name
}
getArea(){
    return `${this.#name}=> ${this.DrawShape()} and the area is ${this.width * this.height}`
}

}

export class Square extends Rectangle{

    constructor(_color,_side){
        super(_color,_side,_side)
    }

}