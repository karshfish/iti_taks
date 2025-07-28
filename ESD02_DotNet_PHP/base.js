import  {Rectangle, Square}  from "./SquaresModule.js";
import { Circle } from "./CircleModule.js";

let Reactangle = new Rectangle("red", 3, 6);
let sqr1 = new Square("green", 5);
let sqr2 = new Square("blue", 7);
let circle = new Circle("pink", 40, 30);

console.log(Reactangle.getArea());
console.log(sqr1.getArea());
console.log(sqr2.getArea());
console.log(circle.getArea());
